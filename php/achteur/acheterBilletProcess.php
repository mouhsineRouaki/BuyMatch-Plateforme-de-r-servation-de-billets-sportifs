<?php
session_start();
require_once '../../classes/Achteur.php';
$ach = Achteur::getAcheteurConnected();


$id_match = $_POST["id_match"];
$prix = $_POST["prix"];
$place = $_POST["place"];
$ticket = [
    'reference' => 'BIL-2026-001',
    'nom_client' => 'Ahmed Ben Ali',
    'categorie' => 'VIP',
    'prix' => 120,
    'place' => 'Bloc A - Place 15'
];

$match = MatchSport::getMatchById($id_match);
if($ach->AcheterBillet($id_match , $prix , $place , $match  ,$ticket)){
    header("Location: ../../pages/achteur/acheterBillet.php?id={$id_match}");
}
