<?php
class Statistique {
    public int $id_statistique ;
    public int $nbBillets;
    public float $chiffreAffaire;

    public function __construct($id_statistique,$nbBillets,$chiffreAffaire) {
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

    public function incrementNbBillets($value){
        $this->nbBillets += $value ;
    }



}