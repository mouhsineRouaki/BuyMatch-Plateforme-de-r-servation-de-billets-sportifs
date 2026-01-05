<?php
session_start();
require_once "../../classes/Achteur.php";
$acheteur = Achteur::getAcheteurConnected();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-white text-gray-900">

<nav class="bg-gray-900 text-white px-6 py-4 flex justify-between">
    <h1 class="text-2xl font-bold">🎫 BuyMatch</h1>
    <a href="../logout.php" class="bg-red-600 px-4 py-2 rounded">Déconnexion</a>
</nav>

<section class="max-w-7xl mx-auto py-20 px-6">
    <h2 class="text-4xl font-bold mb-12">Espace Acheteur</h2>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <a href="matches.php" class="bg-gray-100 p-8 rounded-xl shadow hover:shadow-lg">
            ⚽ Matchs disponibles
        </a>
        <a href="mesBillets.php" class="bg-gray-100 p-8 rounded-xl shadow hover:shadow-lg">
            🎟️ Mes billets
        </a>
        <a href="../profil.php" class="bg-gray-100 p-8 rounded-xl shadow hover:shadow-lg">
            👤 Mon profil
        </a>
    </div>
</section>

</body>
</html>
