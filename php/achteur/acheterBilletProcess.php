<?php
session_start();
require_once '../../classes/Achteur.php';
$ach = Achteur::getAcheteurConnected();


$id_match = $_POST["id_match"];
$prix = $_POST["prix"];
$place = $_POST["place"];
if($ach->AcheterBillet($id_match , $prix , $place)){
    header("Location: ../../pages/achteur/acheterBillet.php?id={$id_match}");
}
