<?php
session_start();
require_once "../classes/Register.php";

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        if (Register::envoyerLienReset($email)) {
            header("Location: ../pages/profil.php");
        } else {
            $message = "<div class='bg-yellow-100 text-yellow-700 p-4 rounded'>Si cet e-mail existe, un lien vous a été envoyé.</div>";
        }
    } else {
        $message = "<div class='bg-red-100 text-red-700 p-4 rounded'>E-mail invalide.</div>";
    }
}