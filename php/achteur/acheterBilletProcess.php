<?php
session_start();
require_once '../../classes/Achteur.php';
$ach = Achteur::getAcheteurConnected();


$id_match = $_POST["id_match"];
$prix = $_POST["prix"];
$place = $_POST["place"];
$nom_category =  $_POST["nom_category"];
$match = MatchSport::getMatchById($id_match);
if($ach->AcheterBillet($id_match , $prix , $place , $match ,$nom_category)){
    header("Location: ../../pages/achteur/acheterBillet.php?id={$id_match}");
}
