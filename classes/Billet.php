<?php
class Billet {
    private int $id_billet;
    private int $id_acheteur;
    private int $id_match;
    private int $id_category;
    private int $place;
    private float $prix;
    private string $QRCode;
    private string $date_achat;

    private ?MatchSport $match = null;
    private ?Category $category = null;
    private PDO $db;

    public function __construct(array $data) {
        $this->db = Database::getInstance()->getConnection();

        $this->id_billet   = $data['id_billet'] ?? 0;
        $this->id_acheteur = $data['id_acheteur'];
        $this->id_match    = $data['id_match'];
        $this->id_category = $data['id_category'];
        $this->place       = $data['place'];
        $this->prix        = $data['prix'];
        $this->QRCode      = $data['QRCode'];
        $this->date_achat  = $data['date_achat'];
    }

    public function __get($name) {
        return $this->$name ?? null;
    }

    public function getMatch(): MatchSport {
        if ($this->match === null) {
            $this->match = MatchSport::getMatchById($this->id_match);
        }
        return $this->match;
    }

    public function getCategory(): Category {
        if ($this->category === null) {
            $stmt = $this->db->prepare("SELECT * FROM category WHERE id_category = ?");
            $stmt->execute([$this->id_category]);
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->category = new Category(
                $data['id_category'],
                $data['nom'],
                $data['prix'],
                $data['nb_place']
            );
        }
        return $this->category;
    }

    public function isMatchPassed(): bool {
        $matchDate = $this->getMatch()->date_match;
        return $matchDate < date('Y-m-d');
    }

    public function getPdfPath(): string {
        return __DIR__ . '/../../tickets/ticket_' . $this->QRCode . '.pdf';
    }

    public function pdfExists(): bool {
        return file_exists($this->getPdfPath());
    }
}