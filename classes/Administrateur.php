<?php
require_once "Utilisateur.php";
require_once __DIR__ . "/../config/Database.php";

class Administrateur extends Utilisateur
{
    public function __construct(int $id ,string $nom,string $prenom,string $email,string $password,?string $phone) {
        parent::__construct($id,$nom, $prenom, $email, $password, $phone, "ORGANISATEUR");
    }

    public static function getOrganisateurConnected(){
        $userConnected = parent::getUserConnected();
        $adm = new Administrateur($userConnected["id_user"],$userConnected["nom"] , $userConnected["prenom"] ,$userConnected["email"] ,$userConnected["password"] ,$userConnected["phone"] );
        return $adm;
    }

    public function getAllUsers()
    {
        $stmt = $this->db->query("
            SELECT id_user, nom, prenom, email, role, actif 
            FROM utilisateur
            WHERE role != 'admin'
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function toggleUserStatus($idUser, $status)
    {
        $stmt = $this->db->prepare("
            UPDATE utilisateur 
            SET actif = ? 
            WHERE id_user = ?
        ");
        return $stmt->execute([$status, $idUser]);
    }

    public function getMatchRequests()
    {
        $stmt = $this->db->query("
            SELECT * FROM match_sport 
            WHERE statut = 'en_attente'
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateMatchStatus($matchId, $status)
    {
        $stmt = $this->db->prepare("
            UPDATE match_sport 
            SET statut = ?
            WHERE id_match = ?
        ");
        return $stmt->execute([$status, $matchId]);
    }
    public function getGlobalStats()
    {
        $stats = [];

        $stats['users'] = $this->db->query("SELECT COUNT(*) FROM utilisateur")->fetchColumn();
        $stats['matchs'] = $this->db->query("SELECT COUNT(*) FROM match_sport")->fetchColumn();
        $stats['billets'] = $this->db->query("SELECT SUM(nb_billets) FROM statistique")->fetchColumn();
        $stats['revenus'] = $this->db->query("SELECT SUM(chiffre_affaire) FROM statistique")->fetchColumn();

        return $stats;
    }
    public function getAllComments()
    {
        $stmt = $this->db->query("
            SELECT c.*, u.nom, u.prenom 
            FROM commentaire c
            JOIN utilisateur u ON u.id_user = c.id_user
            ORDER BY c.date_creation DESC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
