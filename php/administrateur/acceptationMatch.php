<?php 
session_start();
require_once "../../classes/Administrateur.php";
$admin = Administrateur::getAdminConnected();
$id_match = $_GET["id"];
$status = $_GET["status"];
if($admin->updateMatchStatus($id_match,$status)){
    header("Location: ../../pages/admin/demandesMatchs.php");
}