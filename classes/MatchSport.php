<?php
class MatchSport {

    public int $id;
    public string $date;
    public string $heure;
    public ?Statistique $statistique;

    public function __construct(int $id, string $date, string $heure, ?Statistique $statistique) {
        $this->id = $id;
        $this->date = $date;
        $this->heure = $heure;
        $this->statistique = $statistique;
    }
}
