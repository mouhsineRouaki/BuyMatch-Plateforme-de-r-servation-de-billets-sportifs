<?php
class Category {
    private ?int $id_category;
    private string $nom;
    private float $prix;
    private int $nb_place;
    private $id_match;
    private PDO $db;

    public function __construct(?int $id_category,string $nom, float $prix, int $nb_place , int $id_match) {
        $this->id_category = $id_category;
        $this->nom = $nom;
        $this->prix = $prix;
        $this->nb_place = $nb_place;
        $this->id_match = $id_match;
        $this->db = Database::getInstance()->getConnection();
    }
    public function __get($name){
        return $this->$name;
    }
    public function __set($name, $value){
        $this->$name = $value;
    }

    public function getNbplacAavailible($id_match , $id_acheteur){
        $stmt =  $this->db->prepare("
            SELECT count(b.id_billet) as total from billet b
            where b.id_match = ? and b.id_category = ? and id_acheteur = ?
        ");
        $stmt->execute([$id_match ,$this->id_category,$id_acheteur]);
        return $stmt->fetch(PDO::FETCH_ASSOC)["total"];
    }
    public function getNbBilletsVendus(int $id_match): int
    {
        $stmt = $this->db->prepare("
            SELECT COUNT(*) AS total 
            FROM billet 
            WHERE id_match = ? AND id_category = ?
        ");
        $stmt->execute([$id_match, $this->id_category]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int) ($result['total'] ?? 0);
    }

    public function getNbPlacesDisponibles(int $id_match): int
    {
        $vendus = $this->getNbBilletsVendus($id_match);
        return max(0, $this->nb_place - $vendus);
    }

    public function save(): void {
        $stmt = $this->db->prepare("
            INSERT INTO category (nom, prix, nb_place, id_match)
            VALUES (?, ?, ?, ?)
        ");
        $stmt->execute([
            $this->nom,
            $this->prix,
            $this->nb_place,
            $this->id_match
        ]);
        $this->id_category = $this->db->lastInsertId();
    }
}
