<?php
session_start();
require_once "../../classes/Administrateur.php";
$admin = Administrateur::getAdminConnected();
$stats = $admin->getGlobalStats();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Admin – BuyMatch</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-b from-black via-gray-900 to-gray-800 text-white">

<!-- NAV -->
<nav class="bg-black/70 backdrop-blur border-b border-white/10">
    <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between">
        <h1 class="text-2xl font-extrabold">🛠 BuyMatch Admin</h1>
        <a href="../logout.php" class="bg-red-600 px-4 py-2 rounded-lg">Déconnexion</a>
    </div>
</nav>

<!-- CONTENT -->
<section class="py-20 max-w-7xl mx-auto px-6">
    <h2 class="text-4xl font-bold mb-12">Tableau de bord</h2>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white/10 p-8 rounded-2xl border-l-4 border-green-500">
            <p class="text-gray-300">Utilisateurs</p>
            <p class="text-4xl font-bold"><?= $stats['users'] ?></p>
        </div>

        <div class="bg-white/10 p-8 rounded-2xl border-l-4 border-blue-500">
            <p class="text-gray-300">Matchs</p>
            <p class="text-4xl font-bold"><?= $stats['matchs'] ?></p>
        </div>

        <div class="bg-white/10 p-8 rounded-2xl border-l-4 border-green-500">
            <p class="text-gray-300">Billets</p>
            <p class="text-4xl font-bold"><?= $stats['billets'] ?? 0 ?></p>
        </div>

        <div class="bg-white/10 p-8 rounded-2xl border-l-4 border-yellow-500">
            <p class="text-gray-300">Revenus</p>
            <p class="text-4xl font-bold"><?= number_format($stats['revenus'], 2) ?> €</p>
        </div>
    </div>
</section>

</body>
</html>
