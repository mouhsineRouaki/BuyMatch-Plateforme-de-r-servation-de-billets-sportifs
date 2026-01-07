<?php
class Category {
    private $id_category;
    private string $nom;
    private float $prix;
    private int $nb_place;
    private PDO $db;

    public function __construct($id_category,string $nom, float $prix, int $nb_place) {
        $this->id_category = $id_category;
        $this->nom = $nom;
        $this->prix = $prix;
        $this->nb_place = $nb_place;
        $this->db = Database::getInstance()->getConnection();
    }
    public function __get($name){
        return $this->$name;
    }
    public function __set($name, $value){
        $this->$name = $value;
    }

    public function getNbplacAavailible($id_match){
        $stmt =  $this->db->prepare("
            SELECT count(b.id_billet) as total from billet b
            join matchf m on m.id_match  = b.id_match
            join category c on c.id_match = b.id_match
            where c.id_match = ? and c.id_category = ?
            group by c.id_category
        ");
        $stmt->execute([$id_match ,$this->id_category]);
        return $stmt->fetch(PDO::FETCH_ASSOC)["total"];
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
            $this->id_b
        ]);
    }
}
