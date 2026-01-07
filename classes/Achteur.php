<?php
require_once "IModifiableProfil.php";
require_once "Equipe.php" ;
require_once "Utilisateur.php";
require_once "MatchSport.php";
require_once "Statistique.php" ;
require __DIR__ . '/../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;




class Achteur extends Utilisateur implements IModifiableProfil {

    public function __construct(int $id ,string $nom,string $prenom,string $email,string $password,?string $phone) {
        parent::__construct($id,$nom, $prenom, $email, $password, $phone, "ACHTEUR");
    }

    public static function getAcheteurConnected(): Achteur {
        $userConnected = parent::getUserConnected();
        return new Achteur($userConnected["id_user"],$userConnected["nom"] , $userConnected["prenom"] ,$userConnected["email"] ,$userConnected["password"] ,$userConnected["phone"] );
    
    }

    public function updateProfil() {
        $stmt = $this->db->prepare("UPDATE utilisateur SET nom=?, prenom=?, email=?, phone=?, password=? WHERE id_user=?");
        return $stmt->execute([$this->nom,$this->prenom,$this->email,$this->phone,password_hash($this->password, PASSWORD_DEFAULT),$this->id]);

    }

    public function getAvailableMatchs(): array {
        $stmt =  $this->db->prepare("
            SELECT m.*, group_concat(e.id_equipe) as idE , group_concat(e.nom) as nomE, group_concat(e.logo) as logoE
            FROM matchf m
            JOIN match_equipe me on me.id_match = m.id_match
            JOIN equipe e ON me.id_equipe = e.id_equipe 
            WHERE m.statut = 'ACCEPTED'
            group by m.id_match
        ");
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $matchs = [];
        foreach($result as $r){
            $listId = explode(",",$r["idE"]);
            $listNom = explode(",",$r["nomE"]);
            $listLogo = explode(",",$r["logoE"]);
            $equipe1 = new Equipe($listId[0] , $listNom[0] , $listLogo[0]);
            $equipe2 = new Equipe($listId[1] , $listNom[1] , $listLogo[1]);
            $matchs[] = new MatchSport($r["id_match"] ,$r["date_match"] , $r["heure"] ,$r["duree"] ,$r["stade"], $r["id_statistique"] , $equipe1 , $equipe2 );
        }
        return $matchs;
    }

    public function AcheterBillet(int $id_match, float $prix, int $place): bool
{
    try {
        $this->db->beginTransaction();

        $stmt = $this->db->prepare("
            SELECT COUNT(*) 
            FROM billet
            WHERE id_acheteur = ? AND id_match = ?
        ");
        $stmt->execute([$this->id, $id_match]);
        $dejaAchetes = (int)$stmt->fetchColumn();

        if ($dejaAchetes >= 4) {
            $this->db->rollBack();
            return false;
        }

        $insert = $this->db->prepare("
            INSERT INTO billet 
            (id_acheteur, id_match, place, prix, QRCode, date_achat)
            VALUES (?, ?, ?, ?, ?, NOW())
        ");

        $qr = uniqid("BM-QR-");

            $insert->execute([
                $this->id,
                $id_match,
                $place,
                $prix,
                $qr
            ]);

        $this->db->commit();

        $this->sendTicketMail($qr, $prix);

        return true;

    } catch (Exception $e) {
        $this->db->rollBack();
        return false;
    }
}
private function sendTicketMail( $qrCodes, float $prix): void
{
    try {
        $mail = new PHPMailer(true);

        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'sdjkhf@gmail.com';
        $mail->Password   = 'mot_de_passe_app';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 465;

        $mail->setFrom('tickets@buymatch.com', 'BuyMatch');
        $mail->addAddress("houtm27@gmail.com", $this->nom);

        $mail->isHTML(true);
        $mail->Subject = '🎫 Vos billets BuyMatch';

        $list = "<ul>";
            $list .= "<li><strong>QR :</strong> {$qrCodes}</li>";
        $list .= "</ul>";

        $mail->Body = "
            <h2>Merci pour votre achat 🎉</h2>
            <p><strong>Nombre de billets :</strong> " . $qrCodes. "</p>
            <p><strong>Prix unitaire :</strong> {$prix} €</p>
            <p><strong>Vos références :</strong></p>
            {$list}
            <hr>
            <p>Présentez ce mail à l’entrée du stade.</p>
        ";

        $mail->send();

    } catch (Exception $e) {
        error_log("Erreur email billet : " . $e->getMessage());
    }
}




    public function getMyBillet() {
        $stmt =  $this->db->prepare("Select * from billet where id_acheteur = ?");
        $stmt->execute([$this->id]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $billet = [];
        foreach($result as $r ){
            $billet[]= new Billet(uniqid("billet_"),$r["prix"] , $r["place"] , $r["date_achat"]);
        }
        return $billet;
        
    }

    public function addComment(Commentaire $commentaire): bool {
        $sql = "INSERT INTO commentaire
                (utilisateur_id, match_id, contenu, note)
                VALUES (?, ?, ?, ?)";

        return $this->db->prepare($sql)->execute([
            $this->id,
        ]);
        $commentaire->insererComentaire ;
    }
    public function logout(): void{
        session_destroy();
    }
}
