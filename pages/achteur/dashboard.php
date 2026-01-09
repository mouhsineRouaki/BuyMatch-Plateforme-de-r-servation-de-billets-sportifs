<?php
session_start();
require_once "../../classes/Achteur.php";
$acheteur = Achteur::getAcheteurConnected();
$role = $_SESSION["role"] ; 
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Espace Acheteur | BuyMatch</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-white text-gray-900">

<!-- ================= NAVBAR ================= -->
<nav class="sticky top-0 z-50 bg-slate-950/90 backdrop-blur border-b border-white/10">
    <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
        <div class="flex items-center gap-3 text-2xl font-extrabold tracking-tight">
            <span class="text-3xl">🎫</span>
            <span>BuyMatch</span>
        </div>

        <ul class="hidden md:flex gap-8 font-semibold text-slate-200">
            <li><a href="dashboard.php" class="hover:text-emerald-400 transition">Dashboard</a></li>
            <li><a href="matches.php" class="text-emerald-400 underline underline-offset-4">Matchs</a></li>
            <li><a href="mesBillets.php" class="hover:text-emerald-400 transition">Mes billets</a></li>
            <li><a href="../profil.php" class="hover:text-emerald-400 transition">Profil</a></li>
        </ul>

        <button onclick="logout()"
                class="px-5 py-2.5 bg-rose-600 rounded-xl hover:bg-rose-700 transition font-semibold shadow-lg">
            Déconnexion
        </button>
    </div>
</nav>

<!-- ================= HERO ================= -->
<section class="bg-gradient-to-r from-gray-900 to-gray-800 text-white py-16">
    <div class="max-w-7xl mx-auto px-4">
        <h1 class="text-4xl font-bold mb-2">
            Bienvenue dans votre espace Acheteur
        </h1>
        <p class="text-gray-300">
            Achetez vos billets, consultez vos matchs et gérez votre profil
        </p>
    </div>
</section>

<!-- ================= CONTENT ================= -->
<section class="py-20 bg-gray-50 min-h-screen">
<div class="max-w-7xl mx-auto px-4">

    <h2 class="text-3xl font-bold mb-12 text-center">
        Accès rapide
    </h2>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

        <!-- Matchs -->
        <a href="matchs.php"
           class="bg-white p-10 rounded-xl shadow-lg hover:shadow-2xl
                  transition transform hover:-translate-y-1 text-center">
            <div class="text-5xl mb-4">⚽</div>
            <h3 class="text-xl font-bold mb-2">Matchs disponibles</h3>
            <p class="text-gray-600">
                Consultez les matchs ouverts à la réservation
            </p>
        </a>

        <!-- Billets -->
        <a href="mesBillets.php"
           class="bg-white p-10 rounded-xl shadow-lg hover:shadow-2xl
                  transition transform hover:-translate-y-1 text-center">
            <div class="text-5xl mb-4">🎟️</div>
            <h3 class="text-xl font-bold mb-2">Mes billets</h3>
            <p class="text-gray-600">
                Retrouvez l’historique de vos billets
            </p>
        </a>

        <!-- Profil -->
        <a href="profil.php"
           class="bg-white p-10 rounded-xl shadow-lg hover:shadow-2xl
                  transition transform hover:-translate-y-1 text-center">
            <div class="text-5xl mb-4">👤</div>
            <h3 class="text-xl font-bold mb-2">Mon profil</h3>
            <p class="text-gray-600">
                Modifiez vos informations personnelles
            </p>
        </a>

    </div>

</div>
</section>

<!-- ================= FOOTER ================= -->
<footer class="bg-gray-900 text-white py-12 border-t-4 border-green-600">
    <div class="max-w-7xl mx-auto px-4 text-center text-gray-400">
        &copy; 2025 BuyMatch – Plateforme de réservation sportive
    </div>
</footer>

<!-- ================= JS ================= -->
<script>
function logout() {
    if (confirm("Voulez-vous vraiment vous déconnecter ?")) {
        window.location.href = "../../auth/logout";
    }
}
</script>

</body>
</html>
