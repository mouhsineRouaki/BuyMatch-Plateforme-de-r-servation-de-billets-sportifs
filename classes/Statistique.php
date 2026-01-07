<?php
class Statistique {
    public $db ; 
    public int $id_statistique ;
    public int $nbBillets;
    public float $chiffreAffaire;

    public function __construct($id_statistique,$nbBillets,$chiffreAffaire) {
        $this->db = Database::getInstance()->getConnection();
        $this->id_statistique =  $id_statistique;
        $this->nbBillets = $nbBillets;
        $this->chiffreAffaire = $chiffreAffaire;
    }
    public function __get($name){
        return $this->$name;
    }
    public function __set($name, $value){
        $this->$name = $value;
    }

    public function incrementNbBillets(){
        $this->nbBillets += 1;
        self::save();
    }
    public function calculerChiffreAffaire(){
        
    }
    private function save(){
        $stmt = $this->db->prepare("update statistique
        set nb_billet_vendus = ?,
        chiffre_affaire = ?
        where id_statistique = ?");
        return $stmt->execute([$this->nbBillets,$this->chiffreAffaire,$this->id_statistique]);
        
    }



}