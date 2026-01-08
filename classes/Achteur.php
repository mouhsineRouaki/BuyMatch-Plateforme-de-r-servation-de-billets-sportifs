<?php
require_once "IModifiableProfil.php";
require_once "Equipe.php";
require_once "Utilisateur.php";
require_once "MatchSport.php";
require_once "Statistique.php";
require __DIR__ . '/../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;






class Achteur extends Utilisateur implements IModifiableProfil
{

    public function __construct(int $id, string $nom, string $prenom, string $email, string $password, ?string $phone)
    {
        parent::__construct($id, $nom, $prenom, $email, $password, $phone, "ACHTEUR");
    }

    public static function getAcheteurConnected(): Achteur
    {
        $userConnected = parent::getUserConnected();
        return new Achteur($userConnected["id_user"], $userConnected["nom"], $userConnected["prenom"], $userConnected["email"], $userConnected["password"], $userConnected["phone"]);

    }

    public function updateProfil()
    {
        $stmt = $this->db->prepare("UPDATE utilisateur SET nom=?, prenom=?, email=?, phone=?, password=? WHERE id_user=?");
        return $stmt->execute([$this->nom, $this->prenom, $this->email, $this->phone, password_hash($this->password, PASSWORD_DEFAULT), $this->id]);

    }
    public function getMyBillets(): array
    {
        $stmt = $this->db->prepare("
        SELECT b.*
        FROM billet b
        WHERE b.id_acheteur = ?
        ORDER BY b.date_achat DESC
    ");
        $stmt->execute([$this->id]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $billets = [];
        foreach ($result as $row) {
            $billets[] = new Billet($row);
        }
        return $billets;
    }

    public function getBillet($id_match){
        $stmt = $this->db->prepare("
            SELECT COUNT(*) 
            FROM billet 
            WHERE id_acheteur = ? AND id_match = ?
        ");
        $stmt->execute([$this->id, $id_match]);
        return $stmt->fetchColumn() > 0;
    }
    public function dejaCommenter($id_match){
        $stmt = $this->db->prepare("
            SELECT COUNT(*) 
            FROM commentaire 
            WHERE id_acheteur = ? AND id_match = ?
        ");
        $stmt->execute([$this->id, $id_match]);
        return $stmt->fetchColumn() > 0;
    }


    public function getAvailableMatchs(): array
    {
        $stmt = $this->db->prepare("
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
        foreach ($result as $r) {
            $listId = explode(",", $r["idE"]);
            $listNom = explode(",", $r["nomE"]);
            $listLogo = explode(",", $r["logoE"]);
            $equipe1 = new Equipe($listId[0], $listNom[0], $listLogo[0]);
            $equipe2 = new Equipe($listId[1], $listNom[1], $listLogo[1]);
            $matchs[] = new MatchSport($r["id_match"], $r["date_match"], $r["heure"], $r["duree"], $r["stade"], $r["id_statistique"], $equipe1, $equipe2);
        }
        return $matchs;
    }
    public function getNbBilletsAchetesPourMatch(int $id_match): int
    {
        $stmt = $this->db->prepare("
        SELECT COUNT(*) 
        FROM billet 
        WHERE id_acheteur = ? AND id_match = ?
    ");
        $stmt->execute([$this->id, $id_match]);
        return (int) $stmt->fetchColumn();
    }

    public function AcheterBillet(int $id_match, float $prix, int $place, MatchSport $matchSport, $category, $idCategory): bool
    {
        try {
            $this->db->beginTransaction();

            $stmt = $this->db->prepare("
            SELECT COUNT(*) 
            FROM billet
            WHERE id_acheteur = ? AND id_match = ?
        ");
            $stmt->execute([$this->id, $id_match]);
            $dejaAchetes = (int) $stmt->fetchColumn();

            if ($dejaAchetes >= 4) {
                $this->db->rollBack();
                return false;
            }

            $insert = $this->db->prepare("
            INSERT INTO billet 
            (id_acheteur, id_match, place, prix, QRCode, date_achat,id_category)
            VALUES (?, ?, ?, ?, ?, NOW(),?)
        ");

            $qr = uniqid("BM-QR-");

            $insert->execute([
                $this->id,
                $id_match,
                $place,
                $prix,
                $qr,
                $idCategory
            ]);

            $this->db->commit();


            $this->sendTicketMail($qr, $prix, $place, $category, $matchSport);

            return true;

        } catch (Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }
    private function sendTicketMail(string $qrCode, float $prix, $place, $category, MatchSport $matchSport): void
    {
        try {
            $mail = new PHPMailer(true);

            $mail->SMTPDebug = 2;
            $mail->Debugoutput = 'html';

            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'houtm27@gmail.com';
            $mail->Password = 'ytoqpktwipwkesdy';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('houtm27@gmail.com', 'BuyMatch');
            $mail->addAddress('rkmohsin66@gmail.com', $this->nom);

            $mail->isHTML(true);
            $mail->Subject = 'Votre billet BuyMatch';
            $mail->Body = "
            <h2>Merci pour votre achat 🎉</h2>
            <p><strong>Nombre de billets :</strong> </p>
            <p><strong>Prix unitaire :</strong> {$prix} €</p>
            <p><strong>Vos références :</strong></p>
            <hr>
            <p>Présentez ce mail à l’entrée du stade.</p>
        ";


            $fillName = $this->generateTicketPDF($matchSport, $prix, $place, $qrCode, $category);
            $mail->addAttachment($fillName);

            $mail->send();

        } catch (Exception $e) {
        }
    }






    public function addComment($contenu , $note , $id_match): bool
    {
        $sql = "INSERT INTO commentaire
                (id_acheteur, id_match, contenu, note ,date_commentaire)
                VALUES (?, ?, ?, ?,NOW())";

        return $this->db->prepare($sql)->execute([
            $this->id,
            $id_match , 
            $contenu,
            $note
        ]);
    }
    public function generateTicketPDF(MatchSport $match, $prix, $place, $QRCode, $category): string
    {
        $pdf = new TCPDF('L', 'mm', [210, 130], true, 'UTF-8', false);
        $pdf->SetMargins(0, 0, 0);
        $pdf->SetAutoPageBreak(false);
        $pdf->AddPage();

        // === COULEURS ===
        $emerald = [16, 185, 129];
        $cyan = [34, 211, 238];
        $dark = [15, 23, 42];
        $light = [241, 245, 249];
        $gray = [100, 116, 139];

        // === HEADER FOND + GRADIENT ===
        $pdf->SetFillColor(...$dark);
        $pdf->Rect(0, 0, 210, 60, 'F');

        // Gradient emerald → cyan (plus doux)
        for ($i = 0; $i < 60; $i += 0.5) {
            $ratio = $i / 60;
            $r = $emerald[0] * (1 - $ratio) + $cyan[0] * $ratio;
            $g = $emerald[1] * (1 - $ratio) + $cyan[1] * $ratio;
            $b = $emerald[2] * (1 - $ratio) + $cyan[2] * $ratio;
            $pdf->SetDrawColor($r, $g, $b);
            $pdf->SetLineWidth(0.5);
            $pdf->Line(0, $i, 210, $i);
        }

        // Titre BuyMatch + icône
        $pdf->SetFont('helvetica', 'B', 18);
        $pdf->SetTextColor(...$light);
        $pdf->SetXY(0, 8);
        $pdf->Cell(210, 10, '🎟 BUYMATCH - BILLET OFFICIEL', 0, 1, 'C');

        // === LOGOS + ÉQUIPES + VS ===
        $logoSize = 35;

        // Fonction helper pour ajouter image depuis chemin ou URL
        $addLogo = function ($logoUrl, $x) use ($pdf, $logoSize) {
            if (!empty($logoUrl)) {
                if (filter_var($logoUrl, FILTER_VALIDATE_URL)) {
                    // URL distante → télécharger temporairement
                    $tmp = tempnam(sys_get_temp_dir(), 'logo_');
                    $imgData = file_get_contents($logoUrl);
                    if ($imgData !== false) {
                        file_put_contents($tmp, $imgData);
                        $pdf->Image('@' . $imgData, $x, 18, $logoSize, $logoSize, '', '', '', true, 300, '', false, false, 0);
                    }
                } elseif (file_exists($logoUrl)) {
                    // Chemin local
                    $pdf->Image($logoUrl, $x, 18, $logoSize, $logoSize, '', '', '', false, 300);
                }
            }
        };

        $addLogo($match->equipe1->logo, 10);

        $pdf->SetFont('helvetica', 'B', 15);
        $pdf->SetTextColor(...$light);
        $pdf->SetXY(110, 25);
        $pdf->Cell(40, 10, $match->equipe1->nom, 0, 0, 'C');

        $pdf->SetTextColor(...$emerald);
        $pdf->SetXY(90, 25);
        $pdf->Cell(30, 10, 'VS', 0, 0, 'C');

        $addLogo($match->equipe2->logo, 160);

        $pdf->SetTextColor(...$light);
        $pdf->SetXY(110, 25);
        $pdf->Cell(40, 10, $match->equipe2->nom, 0, 0, 'C');

        $pdf->SetFont('helvetica', '', 13);
        $pdf->SetTextColor(...$light);
        $pdf->SetXY(10, 48);
        $pdf->Cell(190, 10, '📅 ' . $match->date_match . '   |   🕐 ' . $match->heure . '   |   🏟 ' . $match->stade, 0, 1, 'C');

        $pdf->SetFillColor(...$light);
        $pdf->SetTextColor(...$dark);
        $pdf->Rect(0, 60, 210, 50, 'F');

        $pdf->SetFont('helvetica', 'B', 15);
        $pdf->SetXY(0, 65);
        $pdf->Cell(210, 8, 'DÉTAILS DU BILLET', 0, 1, 'C');

        $pdf->SetFont('helvetica', '', 13);
        $startY = 75;
        $lineH = 8;

        $pdf->SetXY(20, $startY);
        $pdf->Cell(60, $lineH, 'Nom client :');
        $pdf->Cell(100, $lineH, $this->nom . ' ' . $this->prenom, 0, 1);

        $pdf->SetX(20);
        $pdf->Cell(60, $lineH, 'Catégorie :');
        $pdf->Cell(100, $lineH, $category, 0, 1);

        $pdf->SetX(20);
        $pdf->Cell(60, $lineH, 'Place :');
        $pdf->SetTextColor(...$emerald);
        $pdf->SetFont('', 'B');
        $pdf->Cell(100, $lineH, $place, 0, 1);

        $pdf->SetTextColor(...$dark);
        $pdf->SetX(20);
        $pdf->Cell(60, $lineH, 'Prix :');
        $pdf->SetTextColor(...$emerald);
        $pdf->SetFont('', 'B', 16);
        $pdf->Cell(100, $lineH, number_format($prix, 2) . ' MAD', 0, 1);

        // Référence + Instruction
        $pdf->SetTextColor(...$gray);
        $pdf->SetFont('', '', 11);
        $pdf->SetXY(0, 102);
        $pdf->Cell(210, 6, 'Référence : ' . $QRCode, 0, 1, 'C');


        // QR Code (plus grand et centré en bas à droite)
        $pdf->write2DBarcode($QRCode, 'QRCODE,H', 150, 70, 40, 40);



        $path = __DIR__ . '/../tickets/';
        if (!is_dir($path))
            mkdir($path, 0777, true);

        $fileName = $path . 'ticket_' . $QRCode . '.pdf';
        $pdf->Output($fileName, 'F');

        return $fileName;
    }

    
    public function logout(): void{
        session_destroy();
    }
}
