<?php
require_once "Utilisateur.php";
require_once "Equipe.php";
require_once "Category.php";
require_once "IModifiableProfil.php";

class Organisateur extends Utilisateur implements IModifiableProfil {

    public function __construct(int $id ,string $nom,string $prenom,string $email,string $password,?string $phone) {
        parent::__construct($id,$nom, $prenom, $email, $password, $phone, "ORGANISATEUR");
    }

    public static function getOrganisateurConnected(){
        $userConnected = parent::getUserConnected();
        $org = new Organisateur($userConnected["id_user"],$userConnected["nom"] , $userConnected["prenom"] ,$userConnected["email"] ,$userConnected["password"] ,$userConnected["phone"] );
        return $org;
    }
    public function updateProfil(): bool {
        $sql = "UPDATE utilisateur SET nom=?, prenom=?, email=?, phone=? WHERE id_user=?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$this->nom,$this->prenom,$this->email,$this->phone,$this->id]);
    }

    public function creerMatch(string $date,string $heure,int $duree,string $statut,array $equipes,array $categories): int {
        $this->db->exec("INSERT INTO statistique () VALUES ()");
        $idStat = $this->db->lastInsertId();
        $stmt = $this->db->prepare("INSERT INTO matchf (date_match, heure, duree, statut, id_organisateur, id_statistique) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$date,$heure,$duree,$statut,$this->id,$idStat]);
        $idMatch = $this->db->lastInsertId();
        foreach ($equipes as $idEquipe) {
            Equipe::lierEquipeMatch($idMatch, $idEquipe);
        }
        foreach ($categories as $cat) {
            $category = new Category(
                $cat['nom'],
                $cat['prix'],
                $cat['nb_place'],
                $idMatch
            );
            $category->save();
        }

        return $idMatch;
    }
    public function getStatistiquesGlobales(): array {

        $sql = "SELECT COUNT(DISTINCT m.id_match) AS total_matchs, COALESCE(SUM(s.nb_billet_vendus),0) AS total_billets,COALESCE(SUM(s.chiffre_affaire),0) AS chiffre_affaire,ROUND(AVG(m.note_moyenne),2) AS note_moyenne
            FROM matchf m
            LEFT JOIN statistique s ON s.id_statistique = m.id_statistique
            WHERE m.id_organisateur = ?
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$this->id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function getMesMatchs(): array {

        $sql = "
            SELECT 
                m.id_match, m.date_match, m.heure,
                s.nb_billet_vendus, s.chiffre_affaire, m.note_moyenne
            FROM matchf m
            LEFT JOIN statistique s ON s.id_statistique = m.id_statistique
            WHERE m.id_organisateur = ?
            ORDER BY m.date_match DESC
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$this->id]);

        $matchs = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $stat = new Statistique(
                $row['nb_billet_vendus'] ?? 0,
                $row['chiffre_affaire'] ?? 0,
                $row['note_moyenne']
            );

            $matchs[] = new MatchSport(
                $row['id_match'],
                $row['date_match'],
                $row['heure'],
                $stat
            );
        }

        return $matchs;
    }
    public function logout(): void{
        session_destroy();
    }
}

