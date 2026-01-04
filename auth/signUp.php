<?php
require_once "../classes/register.php";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $register = new Register(
        $_POST['nom'],
        $_POST['prenom'],
        $_POST['email'],
        $_POST['pass'],
        $_POST['phone'],
        $_POST['role'],
    );

    $result = $register->inscrire();

    if ($result['success']) {
        header("Location: ../public/index.php");
        exit();   
    } else {
        header("Location: ../public/index.php");
        exit();      
    }
}
