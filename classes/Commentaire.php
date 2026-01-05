<?php 
class Commentaire {
    private $id_commentaire ;
    private $contenu;
    private $note ;
    private $date_commentaire;
    private $id_match;
    private $id_achteur;
    private $db;
    public function __construct($id , $contenu , $note,$date_commentaire , $id_match , $id_achteur){
        $this->db = Database::getInstance()->getConnection();
        $this->id_commentaire = $id;
        $this->contenu = $contenu ; 
        $this->note = $note ;
        $this->date_commentaire = $date_commentaire;
        $this->id_match = $id_match;
        $this->id_achteur = $id_achteur;
    }

    public function __get($name){
        return $this->$name;
    }
    public function __set($name, $value){
        $this->$name = $value;
    }
}