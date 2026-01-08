<?php 
session_start();
$connecter = true ;
if(!isset($_SESSION["id_user"])){
    header("Location: ../public/index.php");
}
