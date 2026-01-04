<?php
class Category {
    private string $nom;
    private float $prix;
    private int $nb_place;
    private int $id_match;
    private PDO $db;

    public function __construct(string $nom, float $prix, int $nb_place, int $id_match) {
        $this->nom = $nom;
        $this->prix = $prix;
        $this->nb_place = $nb_place;
        $this->id_match = $id_match;
        $this->db = Database::getInstance()->getConnection();
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
