<?php
session_start();
require_once "../classes/Register.php";

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $re = new Register('' ,'');

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        if (Achteur::envoyerLienReset($email)) {
            $message = "<div class='bg-green-100 text-green-700 p-4 rounded'>Un lien de réinitialisation a été envoyé à votre e-mail !</div>";
        } else {
            $message = "<div class='bg-yellow-100 text-yellow-700 p-4 rounded'>Si cet e-mail existe, un lien vous a été envoyé.</div>";
        }
    } else {
        $message = "<div class='bg-red-100 text-red-700 p-4 rounded'>E-mail invalide.</div>";
    }
}