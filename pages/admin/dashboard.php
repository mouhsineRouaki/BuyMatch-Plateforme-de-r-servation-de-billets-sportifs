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
    <title>Admin – Dashboard | BuyMatch</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-white text-gray-900">

<!-- ================= NAVBAR ================= -->
<nav class="sticky top-0 z-50 bg-gray-900 text-white shadow-lg">
    <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
        <div class="flex items-center gap-2 text-2xl font-bold">
            <span>🛠️</span>
            <span>BuyMatch Admin</span>
        </div>

        <ul class="hidden md:flex gap-8 font-semibold">
            <li><a href="dashboard.php" class="text-green-500">Dashboard</a></li>
            <li><a href="utilisateurs.php" class="hover:text-green-500 transition">Utilisateurs</a></li>
            <li><a href="demandesMatchs.php" class="hover:text-green-500 transition">Demandes de matchs</a></li>
            <li><a href="commentaires.php" class="hover:text-green-500 transition">Commentaires</a></li>
        </ul>

        <button onclick="logout()"
                class="px-4 py-2 bg-red-600 rounded hover:bg-red-700 transition">
            Déconnexion
        </button>
    </div>
</nav>

<!-- ================= HERO ================= -->
<section class="bg-gradient-to-r from-gray-900 to-gray-800 text-white py-14">
    <div class="max-w-7xl mx-auto px-4">
        <h1 class="text-4xl font-bold mb-2">Tableau de bord Administrateur</h1>
        <p class="text-gray-300">
            Vue globale sur l’activité de la plateforme BuyMatch
        </p>
    </div>
</section>

<!-- ================= CONTENT ================= -->
<section class="py-16 bg-gray-50 min-h-screen">
<div class="max-w-7xl mx-auto px-4">

    <!-- ================= STATS ================= -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

        <!-- Utilisateurs -->
        <div class="bg-white p-8 rounded-xl shadow-md border-l-4 border-green-600 hover:shadow-lg transition">
            <p class="text-gray-600 text-sm font-semibold">Utilisateurs</p>
            <p class="text-4xl font-bold mt-2"><?= $stats['users'] ?></p>
            <p class="text-sm text-gray-500 mt-1">Tous rôles confondus</p>
        </div>

        <!-- Matchs -->
        <div class="bg-white p-8 rounded-xl shadow-md border-l-4 border-blue-600 hover:shadow-lg transition">
            <p class="text-gray-600 text-sm font-semibold">Matchs</p>
            <p class="text-4xl font-bold mt-2"><?= $stats['matchs'] ?></p>
            <p class="text-sm text-gray-500 mt-1">Créés & validés</p>
        </div>

        <!-- Billets -->
        <div class="bg-white p-8 rounded-xl shadow-md border-l-4 border-purple-600 hover:shadow-lg transition">
            <p class="text-gray-600 text-sm font-semibold">Billets vendus</p>
            <p class="text-4xl font-bold mt-2"><?= $stats['billets'] ?? 0 ?></p>
            <p class="text-sm text-gray-500 mt-1">Toutes catégories</p>
        </div>

        <!-- Revenus -->
        <div class="bg-white p-8 rounded-xl shadow-md border-l-4 border-yellow-500 hover:shadow-lg transition">
            <p class="text-gray-600 text-sm font-semibold">Revenus totaux</p>
            <p class="text-4xl font-bold mt-2">
                <?= number_format($stats['revenus'], 2) ?> €
            </p>
            <p class="text-sm text-gray-500 mt-1">Chiffre d’affaires global</p>
        </div>

    </div>

</div>
</section>

<!-- ================= FOOTER ================= -->
<footer class="bg-gray-900 text-white py-12 border-t-4 border-green-600">
    <div class="max-w-7xl mx-auto px-4 text-center text-gray-400">
        &copy; 2025 BuyMatch – Administration
    </div>
</footer>

<script>
function logout() {
    if (confirm("Voulez-vous vraiment vous déconnecter ?")) {
        window.location.href = "../../index.php";
    }
}
</script>

</body>
</html>
