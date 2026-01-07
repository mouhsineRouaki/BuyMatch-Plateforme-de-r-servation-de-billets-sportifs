<?php
session_start();
require_once '../../classes/Achteur.php';
$ach = Achteur::getAcheteurConnected();


$id_match = $_POST["id_match"];
$prix = $_POST["prix"];
$place = $_POST["place"];
$nbTicket = $_POST["nbTicket"];
if($ach->AcheterBillet($id_match , $prix , $place,$nbTicket)){
    header("Location: ../../pages/achteur/acheterBillet.php");
}
