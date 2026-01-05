<?php 
session_start();
require_once "../../classes/Administrateur.php";
$admin = Administrateur::getAdminConnected();
$id_user = $_POST["id"];
$status = $_POST["status"];
if($admin->toggleUserStatus($id_user , $status)){
    header("Location: ../../pages/admin/utilisateurs.php");
}