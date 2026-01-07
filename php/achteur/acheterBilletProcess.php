<?php
session_start();
require_once '../../classes/Achteur.php';
$ach = Achteur::getAcheteurConnected();


$id_match = $_POST["id_match"];
$prix = $_POST["prix"];
$place = $_POST["place"];
$id_category =  $_POST["id_category"];
$match = MatchSport::getMatchById($id_match);
$category = $match->getCategoryById($id_category);
if($ach->AcheterBillet($id_match , $prix , $place , $match ,$category)){
    header("Location: ../../pages/achteur/acheterBillet.php?id={$id_match}");
}
