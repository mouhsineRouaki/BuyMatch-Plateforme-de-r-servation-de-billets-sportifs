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

<body class="bg-gradient-to-b from-black to-gray-900 text-white">

<nav class="bg-black/70 border-b border-white/10 px-6 py-4 flex justify-between">
    <h1 class="text-2xl font-bold">🎫 BuyMatch</h1>
    <a href="../logout.php" class="bg-red-600 px-4 py-2 rounded-lg">Déconnexion</a>
</nav>

<section class="max-w-7xl mx-auto py-20 px-6">
    <h2 class="text-4xl font-bold mb-10">Bienvenue 👋</h2>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <a href="matchs.php" class="bg-white/10 p-8 rounded-xl hover:scale-105 transition">
            ⚽ Matchs disponibles
        </a>
        <a href="mesBillets.php" class="bg-white/10 p-8 rounded-xl hover:scale-105 transition">
            🎟️ Mes billets
        </a>
        <a href="profil.php" class="bg-white/10 p-8 rounded-xl hover:scale-105 transition">
            👤 Mon profil
        </a>
    </div>
</section>

</body>
</html>
