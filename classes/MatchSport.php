<?php
require_once "Commentaire.php";
require_once "Category.php";


class MatchSport {

    public int $id_match;
    public string $date_match;
    public string $heure;
    public $duree;
    private $noteMoyenne ;
    private $nbTotal ;
    private $stade ;
    public Equipe $equipe1;
    public Equipe $equipe2;
    public $id_statistique;
    private $id_organisateur ;
    public ?Statistique $statistique;
    public $commentaires;
    public $categories ;
    private $db;


    public function __construct(int $id, string $date, string $heure , $duree ,$stade, $id_statistique , $equipe1 , $equipe2) {
        $this->db = Database::getInstance()->getConnection();
        $this->id_match = $id;
        $this->date_match = $date;
        $this->heure = $heure;
        $this->duree = $duree;
        $this->stade  = $stade;
        $this->id_statistique = $id_statistique;
        $this->equipe1 = $equipe1 ; 
        $this->equipe2 = $equipe2;
        $this->statistique = self::getStatistique(); 
        $this->commentaires = self::getCommentaires();
        $this->categories = self::getCategories();
        
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

    public function getCategories(){
        $stmt = $this->db->prepare("select * from category where id_match = ?");
        $stmt->execute([$this->id_match]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $categories = [];
        foreach($result as $r){
            $categories[] = new Category($r["id_category"],$r["nom"], $r["prix"] , $r["nb_place"] );
        }
        return $categories;

    }
    public static function getMatchById($id_match){
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT m.*, group_concat(e.id_equipe) as idE , group_concat(e.nom) as nomE, group_concat(e.logo) as logoE
            FROM matchf m
            JOIN match_equipe me on me.id_match = m.id_match
            JOIN equipe e ON me.id_equipe = e.id_equipe 
            WHERE m.id_match = ?
            group by m.id_match");
        $stmt->execute([$id_match]);
        $r= $stmt->fetch(PDO::FETCH_ASSOC);
        $listId = explode(",",$r["idE"]);
        $listNom = explode(",",$r["nomE"]);
        $listLogo = explode(",",$r["logoE"]);
        $equipe1 = new Equipe($listId[0] , $listNom[0] , $listLogo[0]);
        $equipe2 = new Equipe($listId[1] , $listNom[1] , $listLogo[1]);
        return  new MatchSport($r["id_match"] ,$r["date_match"] , $r["heure"] ,$r["duree"] ,$r["stade"], $r["id_statistique"] , $equipe1 , $equipe2 );
    }

    public function getCategoryById($id):?Category{
        for( $i = 0 ; $i <= count($this->categories) ; $i++){
            $cat = $this->categories[$i];
            if($cat->id_category === $id){
                return $cat;
            }
        }
    }

}
