<?php
class Billet {
    private $id_billet;
    private string $QRCode;
    private float $dateAchat;
    private int $place;
    private float  $prix;

    private $commentaire ; 
    private PDO $db;

    public function __construct(string $QRCode, float $prix, int $place , int $dateAchat) {
        $this->nom = $QRCode;
        $this->prix = $prix;
        $this->place = $place;
        $this->dateAchat = $dateAchat;
        $this->db = Database::getInstance()->getConnection();
    }
    public function __get($name){
        return $this->$name;
    }
    public function __set($name, $value){
        $this->$name = $value;
    }

    public function getCommentaire(){
        
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
    }
}
