<?php
session_start();
require_once '../classes/Organisateur.php';
$org = Organisateur::getOrganisateurConnected();
$org->nom = $_POST["nom"];
$org->prenom = $_POST["prenom"];
$org->email = $_POST["email"];
$org->phone = $_POST["phone"];
$org->password = $_POST["password"];
if($org->updateProfil()){
    header("Location: ../pages/profil.php");
}

