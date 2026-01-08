<?php
session_start();
require_once '../../classes/Achteur.php';
$ach = Achteur::getAcheteurConnected();


$id_match = $_POST["id_match"];
$prix = $_POST["prix"];
$place = $_POST["place"];
$category = $_POST["nom_category"];
$id = $_POST["id_category"];


$match = MatchSport::getMatchById($id_match);
$ach->AcheterBillet($id_match , $prix , $place , $match,$category  ,$id);
