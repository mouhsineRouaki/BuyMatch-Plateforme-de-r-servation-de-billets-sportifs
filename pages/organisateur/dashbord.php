<?php
session_start();

require_once "../../config/Database.php";
require_once "../../classes/Utilisateur.php";
require_once "../../classes/Organisateur.php";
require_once "../../classes/MatchSport.php";
require_once "../../classes/Statistique.php";

$organisateur = Organisateur::getOrganisateurConnected();
$stats = $organisateur->getStatistiquesGlobales();
$matchs = $organisateur->getMesMatchs();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>BuyMatch – Dashboard Organisateur</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-b from-black via-gray-900 to-gray-800 text-white">

<!-- ================= NAVBAR ================= -->
<nav class="fixed top-0 w-full z-50 backdrop-blur bg-black/60 border-b border-white/10">
    <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
        <div class="flex items-center gap-2 text-2xl font-extrabold tracking-wide">
            ⚽ <span>BuyMatch</span>
        </div>

        <ul class="hidden md:flex gap-10 font-semibold">
            <li>
                <a href="#" class="text-green-400 border-b-2 border-green-400">
                    Dashboard
                </a>
            </li>
            <li>
                <a href="creeDemandeMatch.php"
                   class="hover:text-green-400 transition border-b-2 border-transparent hover:border-green-400">
                    Créer un match
                </a>
            </li>
            <li>
                <a href="../profil.php"
                   class="hover:text-green-400 transition border-b-2 border-transparent hover:border-green-400">
                    Profil
                </a>
            </li>
        </ul>

        <button onclick="logout()"
                class="px-4 py-2 bg-red-600 rounded-lg hover:bg-red-700 transition">
            Déconnexion
        </button>
    </div>
</nav>

<!-- ================= HERO ================= -->
<section class="pt-32 pb-20 text-center bg-[radial-gradient(ellipse_at_top,_var(--tw-gradient-stops))] from-green-600/30 via-transparent to-transparent">
    <div class="max-w-5xl mx-auto px-6">
        <h1 class="text-5xl font-extrabold mb-4">
            Tableau de bord
        </h1>
        <p class="text-gray-300 text-lg">
            Analysez vos performances et gérez vos matchs
        </p>
    </div>
</section>

<!-- ================= CONTENT ================= -->
<section class="pb-20">
<div class="max-w-7xl mx-auto px-6">

<!-- ================= STATS ================= -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">

    <div class="bg-white/10 backdrop-blur-xl rounded-2xl p-8 shadow-lg border border-white/10">
        <p class="text-gray-300 text-sm font-semibold uppercase">Matchs créés</p>
        <p class="text-5xl font-extrabold mt-3 text-green-400">
            <?= $stats['total_matchs'] ?>
        </p>
    </div>

    <div class="bg-white/10 backdrop-blur-xl rounded-2xl p-8 shadow-lg border border-white/10">
        <p class="text-gray-300 text-sm font-semibold uppercase">Billets vendus</p>
        <p class="text-5xl font-extrabold mt-3 text-blue-400">
            <?= $stats['total_billets'] ?>
        </p>
    </div>

    <div class="bg-white/10 backdrop-blur-xl rounded-2xl p-8 shadow-lg border border-white/10">
        <p class="text-gray-300 text-sm font-semibold uppercase">Revenus totaux</p>
        <p class="text-5xl font-extrabold mt-3 text-green-400">
            <?= number_format($stats['chiffre_affaire'], 2) ?> €
        </p>
    </div>

</div>

<!-- ================= MATCHS ================= -->
<div class="bg-white/10 backdrop-blur-xl rounded-3xl shadow-2xl p-10 border border-white/10">

    <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-6 mb-10">
        <h2 class="text-3xl font-extrabold">Mes Matchs</h2>

        <a href="creeDemandeMatch.php"
           class="px-6 py-3 bg-green-600 rounded-xl hover:bg-green-700 transition font-bold">
            + Créer un match
        </a>
    </div>

    <div class="space-y-6">
        <?php if (empty($matchs)): ?>
            <p class="text-center text-gray-400">Aucun match créé</p>
        <?php endif; ?>

        <?php foreach ($matchs as $match): ?>
            <div class="flex flex-col md:flex-row justify-between gap-6 p-6 rounded-2xl bg-black/40 border border-white/10 hover:bg-black/60 transition">

                <div>
                    <h3 class="text-2xl font-bold mb-1">
                        Match #<?= $match->id ?>
                    </h3>

                    <p class="text-gray-300">
                        📅 <?= $match->date ?> • 🕐 <?= $match->heure ?>
                    </p>

                    <p class="text-gray-400 mt-1">
                        🎫 <?= $match->statistique->nbBillets ?> billets vendus
                    </p>
                </div>

                <div class="text-right">
                    <p class="text-3xl font-extrabold text-green-400">
                        <?= number_format($match->statistique->chiffreAffaire, 2) ?> €
                    </p>

                    <p class="text-sm text-gray-400 mt-1">
                        ⭐ <?= $match->statistique->noteMoyenne ?? '—' ?>
                    </p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

</div>

</div>
</section>

<!-- ================= FOOTER ================= -->
<footer class="bg-black/90 py-10 text-center text-gray-400 border-t border-white/10">
    © 2025 BuyMatch – Football Ticketing Platform
</footer>

<script>
function logout() {
    window.location.href = "../../index.php";
}
</script>

</body>
</html>
