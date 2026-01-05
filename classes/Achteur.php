<?php
require_once "IModifiableProfil.php";
require_once "Utilisateur.php";


class Achteur extends Utilisateur implements IModifiableProfil {

    public function __construct(int $id ,string $nom,string $prenom,string $email,string $password,?string $phone) {
        parent::__construct($id,$nom, $prenom, $email, $password, $phone, "ACHTEUR");
    }

    public static function getAcheteurConnected(): Achteur {
        $userConnected = parent::getUserConnected();
        return new Achteur($userConnected["id_user"],$userConnected["nom"] , $userConnected["prenom"] ,$userConnected["email"] ,$userConnected["password"] ,$userConnected["phone"] );
    
    }

    public function updateProfil() {
        $sql = "UPDATE utilisateur 
                SET nom=?, prenom=?, email=?, phone=?, password=? 
                WHERE id_user=?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
                $this->nom,
                $this->prenom,
                $this->email,
                $this->phone,
                password_hash($this->password, PASSWORD_DEFAULT),
                $this->id
        ]);

        return true;
    }

    /* ================= MATCHS ================= */
    public function getAvailableMatchs(): array {
        return $this->db->query("
            SELECT m.*, e1.nom AS equipe1, e1.logo AS logo1,
                         e2.nom AS equipe2, e2.logo AS logo2
            FROM match_football m
            JOIN equipe e1 ON m.equipe1_id = e1.id
            JOIN equipe e2 ON m.equipe2_id = e2.id
            WHERE m.statut = 'accepte'
        ")->fetchAll();
    }

    /* ================= BILLETS ================= */
    public function buyTicket(array $data): bool {
        // max 4 billets
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
            SELECT b.*, m.date, m.heure,
                   e1.nom AS equipe1, e2.nom AS equipe2
            FROM billet b
            JOIN match_football m ON b.match_id = m.id
            JOIN equipe e1 ON m.equipe1_id = e1.id
            JOIN equipe e2 ON m.equipe2_id = e2.id
            WHERE acheteur_id=?
        ")->execute([$this->id])->fetchAll();
    }

    /* ================= COMMENTAIRES ================= */
    public function addComment(array $data): bool {
        $sql = "INSERT INTO commentaire
                (utilisateur_id, match_id, contenu, note)
                VALUES (?, ?, ?, ?)";

        return $this->db->prepare($sql)->execute([
            $this->id,
            $data['match_id'],
            $data['contenu'],
            $data['note']
        ]);
    }
    public function logout(): void{
        session_destroy();
    }
}
