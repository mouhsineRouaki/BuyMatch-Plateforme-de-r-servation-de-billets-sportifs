<?php 
session_start();
$connecter = true ;
if(!isset($_SESSION["id_user"])){
    session_destroy();
    header("Location: ../public/index.php");
}
