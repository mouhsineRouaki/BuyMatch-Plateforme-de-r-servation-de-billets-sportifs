<?php
session_start();
require_once "../classes/Organisateur.php";

$organisateur = Organisateur::getOrganisateurConnected();

$organisateur->creerMatch(
    $_POST['date'],
    $_POST['heure'],
    $_POST['duree'],
    "EN_ATTENTE",
    $_POST["stade"],
    $_POST['equipes'],
    $_POST['categories']
);

header("Location: ../organisateur/dashboard.php");
