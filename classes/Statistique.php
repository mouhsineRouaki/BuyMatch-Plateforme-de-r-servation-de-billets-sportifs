<?php
class Statistique {
    public int $nbBillets;
    public float $chiffreAffaire;
    public ?float $noteMoyenne;

    public function __construct(int $nbBillets, float $chiffreAffaire, ?float $noteMoyenne) {
        $this->nbBillets = $nbBillets;
        $this->chiffreAffaire = $chiffreAffaire;
        $this->noteMoyenne = $noteMoyenne;
    }
}