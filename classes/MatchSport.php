<?php
require_once "Commentaire.php";


class MatchSport {

    public int $id_match;
    public string $date_match;
    public string $heure;
    public $duree;
    private $noteMoyenne ;
    private $nbTotal ;
    public Equipe $equipe1;
    public Equipe $equipe2;
    public $id_statistique;
    private $id_organisateur ;
    public ?Statistique $statistique;
    public $commentaires;
    private $db;

    public function __construct(int $id, string $date, string $heure , $duree , $id_statistique , $equipe1 , $equipe2) {
        $this->db = Database::getInstance()->getConnection();
        $this->id_match = $id;
        $this->date_match = $date;
        $this->heure = $heure;
        $this->duree = $duree;
        $this->id_statistique = $id_statistique;
        $this->equipe1 = $equipe1 ; 
        $this->equipe2 = $equipe2;
        $this->statistique = self::getStatistique(); 
        $this->commentaires = self::getCommentaires();

    }

    public function __get($name){
        return $this->$name;
    }
    public function __set($name, $value){
        $this->$name = $value;
    }

    public function getStatistique(){
        $stmt = $this->db->prepare("select * from statistique where id_statistique = ?");
        $stmt->execute([$this->id_statistique]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return new Statistique($this->id_statistique , $result["nb_billet_vendus"] , $result["chiffre_affaire"]);
    }
    public function getCommentaires(){
        $stmt = $this->db->prepare("select * from commentaire where id_match = ?");
        $stmt->execute([$this->id_match]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $commentaires = [];
        foreach($result as $r){
            $commentaires[] = new Commentaire($r["id_commentaire"], $r["contenu"] , $r["note"] , $r["date_commentaire"] ,$r["id_match"],$r["id_acheteur"]);
        }
        return $commentaires;
    }

}
