<?php
require_once "IModifiableProfil.php";
require_once "Equipe.php" ;
require_once "Utilisateur.php";
require_once "MatchSport.php";
require_once "Statistique.php" ;


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
            $matchs[] = new MatchSport($r["id_match"] ,$r["date_match"] , $r["heure"] ,$r["duree"] , $r["id_statistique"] , $equipe1 , $equipe2 );
        }
        return $matchs;
    }

    public function buyTicket(array $data): bool {
        $stmt = $this->db->prepare("
            SELECT COUNT(*) FROM billet
            WHERE acheteur_id=? AND match_id=?
        ");
        $stmt->execute([$this->id, $data['match_id']]);

        if ($stmt->fetchColumn() >= 4) return false;

        $sql = "INSERT INTO billet (acheteur_id, match_id, categorie, place, prix, qr_code)
                VALUES (?, ?, ?, ?, ?, ?)";

        return $this->db->prepare($sql)->execute([
            $this->id,
            $data['match_id'],
            $data['categorie'],
            $data['place'],
            $data['prix'],
            uniqid("BM-QR-")
        ]);
    }

    public function getMyTickets(): array {
        return $this->db->prepare("
            SELECT b.*, m.date_match, m.heure,AS equipe1, e2.nom AS equipe2
            FROM billet b
            JOIN matchf m ON b.match_id = m.id
            JOIN match_equipe me on me.id_match= m.id_match
            JOIN equipe e ON me.id_equipe = e.id_equipe
            WHERE acheteur_id=?
        ")->execute([$this->id])->fetchAll(PDO::FETCH_ASSOC);
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
