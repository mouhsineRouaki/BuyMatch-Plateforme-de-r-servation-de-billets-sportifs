<?php
class Equipe {
    private $id;
    private string $nom;
    private $logo ;
    private PDO $db;

    public function __construct($id,string $nom , $logo) {
        $this->id;
        $this->nom = $nom;
        $this->logo = $logo;
        $this->db = Database::getInstance()->getConnection();
    }

    public function __get($name){
        return $this->$name;
    }
    public function __set($name, $value){
        $this->$name = $value;
    }

    public function save(): int {
        $stmt = $this->db->prepare("INSERT INTO equipe (id,nom , logo) VALUES (?,?,?)");
        $stmt->execute([$this->id ,$this->nom , $this->logo]);
        return $this->db->lastInsertId();
    }
    public static function lierEquipeMatch($idMatch, $idEquipe): int {
        $db = Database::getInstance()->getConnection();
        $db->prepare("INSERT INTO match_equipe VALUES (?, ?)")->execute([$idMatch, $idEquipe]);
        return $db->prepare("INSERT INTO match_equipe VALUES (?, ?)")->execute([$idMatch, $idEquipe]);
    }
}
