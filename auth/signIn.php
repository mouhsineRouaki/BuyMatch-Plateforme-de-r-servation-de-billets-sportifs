<?php 
require_once "../classes/Login.php";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = $_POST["email"];
    $password = $_POST["password"];
    $login =new  Login($email,$password);
    $result = $login->connecter();
    if ($result['success']) {
        if($result["role"] === "ACHTEUR"){
            header("Location: ../pages/coach/dashbordCoach.php");
        }else if ($result["role"] === "ORGANISATEUR"){
            header("Location: ../pages/organisateur/dashbord.php");
        }else{
            header("Location: ../../pages/sportif/dashbordSportif.php");
        }
        exit();   
    } else {
        header("Location: ../../public/index.php?message=" . $result['message'].$email.$password);
        exit();      
    }

    
}
