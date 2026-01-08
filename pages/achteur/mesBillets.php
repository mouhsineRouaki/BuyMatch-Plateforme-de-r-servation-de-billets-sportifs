<?php
session_start();
require_once "../../classes/Achteur.php";
$a = Achteur::getAcheteurConnected();
$tickets = $a->getMyTickets();
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mes Tickets | BuyMatch</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-950 text-slate-100">

<!-- ================= NAVBAR ================= -->
<nav class="sticky top-0 z-50 bg-slate-950/90 backdrop-blur border-b border-white/10 shadow-lg">
    <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
        <div class="flex items-center gap-2 text-2xl font-extrabold tracking-tight">
            <span class="text-2xl">🎫</span>
            <span>BuyMatch</span>
        </div>

        <ul class="hidden md:flex gap-8 font-semibold text-slate-200">
            <li><a href="dashboard.php" class="hover:text-emerald-400 transition">Dashboard</a></li>
            <li><a href="matchs.php" class="hover:text-emerald-400 transition">Matchs</a></li>
            <li><a href="mesBillets.php" class="text-emerald-400">Mes billets</a></li>
            <li><a href="profil.php" class="hover:text-emerald-400 transition">Profil</a></li>
        </ul>

        <button onclick="logout()"
                class="px-4 py-2 bg-rose-600 rounded-lg hover:bg-rose-700 transition font-semibold">
            Déconnexion
        </button>
    </div>
</nav>

<!-- ================= HERO ================= -->
<header class="relative overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-r from-slate-950 via-slate-900 to-slate-950"></div>
    <div class="absolute -top-24 -right-24 w-72 h-72 bg-emerald-500/20 blur-3xl rounded-full"></div>
    <div class="absolute -bottom-24 -left-24 w-72 h-72 bg-cyan-500/20 blur-3xl rounded-full"></div>

    <div class="relative max-w-7xl mx-auto px-4 py-16">
        <h1 class="text-4xl md:text-5xl font-extrabold tracking-tight mb-2">
            Mes Tickets
        </h1>
        <p class="text-slate-300">
            Vos billets réservés, prêts à être utilisés ou imprimés.
        </p>
    </div>
</header>

<!-- ================= TICKETS GRID ================= -->
<main class="py-12">
    <div class="max-w-7xl mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

            <!-- TICKET 1 -->
            <article class="ticket group bg-white/5 border border-white/20 rounded-2xl overflow-hidden shadow-2xl hover:shadow-emerald-500/20 hover:border-emerald-500/40 transition-all duration-300">
                <div class="bg-gradient-to-br from-emerald-600/20 to-cyan-600/20 p-8 relative">
                    <div class="absolute top-4 right-4 text-6xl opacity-10">🎟</div>
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center gap-4">
                            <img src="https://upload.wikimedia.org/wikipedia/en/4/43/Raja_Club_Athletic.png" alt="Raja Casablanca" class="w-20 h-20 rounded-full border-4 border-white/20 object-contain bg-white/10">
                            <div>
                                <p class="text-2xl font-extrabold">Raja Casablanca</p>
                            </div>
                        </div>
                        <div class="text-3xl font-bold text-emerald-400">VS</div>
                        <div class="flex items-center gap-4">
                            <div class="text-right">
                                <p class="text-2xl font-extrabold">Wydad Casablanca</p>
                            </div>
                            <img src="https://upload.wikimedia.org/wikipedia/en/0/0d/Wydad_AC_logo.png" alt="Wydad Casablanca" class="w-20 h-20 rounded-full border-4 border-white/20 object-contain bg-white/10">
                        </div>
                    </div>
                </div>

                <div class="p-6 space-y-4 bg-slate-900/50">
                    <div class="grid grid-cols-2 gap-4 text-center">
                        <div class="bg-white/5 border border-white/10 rounded-xl p-4">
                            <p class="text-sm text-slate-400">📅 Date</p>
                            <p class="font-extrabold text-lg">15 Mars 2026</p>
                        </div>
                        <div class="bg-white/5 border border-white/10 rounded-xl p-4">
                            <p class="text-sm text-slate-400">🕐 Heure</p>
                            <p class="font-extrabold text-lg">20:00</p>
                        </div>
                    </div>
                    <div class="bg-white/5 border border-white/10 rounded-xl p-4 text-center">
                        <p class="text-sm text-slate-400">🏟 Stade</p>
                        <p class="font-extrabold text-lg">Stade Mohammed V</p>
                    </div>
                    <div class="grid grid-cols-3 gap-4 text-center">
                        <div class="bg-emerald-500/10 border border-emerald-500/30 rounded-xl p-4">
                            <p class="text-sm text-slate-400">Prix</p>
                            <p class="font-extrabold text-xl text-emerald-400">350 MAD</p>
                        </div>
                        <div class="bg-white/5 border border-white/10 rounded-xl p-4">
                            <p class="text-sm text-slate-400">Catégorie</p>
                            <p class="font-bold">Tribune Latérale</p>
                        </div>
                        <div class="bg-white/5 border border-white/10 rounded-xl p-4">
                            <p class="text-sm text-slate-400">Place</p>
                            <p class="font-bold">A12 - Rang 8</p>
                        </div>
                    </div>
                    <div class="text-center pt-4">
                        <p class="text-xs text-slate-500">Billet n° <span class="font-mono text-emerald-400">TKT-2026-0481</span></p>
                    </div>
                </div>
                <div class="h-1 bg-gradient-to-r from-emerald-500 via-cyan-500 to-emerald-500 opacity-60 group-hover:opacity-100 transition"></div>
            </article>

            <!-- TICKET 2 (exemple différent) -->
            <article class="ticket group bg-white/5 border border-white/20 rounded-2xl overflow-hidden shadow-2xl hover:shadow-emerald-500/20 hover:border-emerald-500/40 transition-all duration-300">
                <div class="bg-gradient-to-br from-emerald-600/20 to-cyan-600/20 p-8 relative">
                    <div class="absolute top-4 right-4 text-6xl opacity-10">🎟</div>
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center gap-4">
                            <img src="https://upload.wikimedia.org/wikipedia/fr/1/1f/AS_FAR_2021_logo.png" alt="AS FAR" class="w-20 h-20 rounded-full border-4 border-white/20 object-contain bg-white/10">
                            <div>
                                <p class="text-2xl font-extrabold">AS FAR</p>
                            </div>
                        </div>
                        <div class="text-3xl font-bold text-emerald-400">VS</div>
                        <div class="flex items-center gap-4">
                            <div class="text-right">
                                <p class="text-2xl font-extrabold">Raja Casablanca</p>
                            </div>
                            <img src="https://upload.wikimedia.org/wikipedia/en/4/43/Raja_Club_Athletic.png" alt="Raja Casablanca" class="w-20 h-20 rounded-full border-4 border-white/20 object-contain bg-white/10">
                        </div>
                    </div>
                </div>

                <div class="p-6 space-y-4 bg-slate-900/50">
                    <div class="grid grid-cols-2 gap-4 text-center">
                        <div class="bg-white/5 border border-white/10 rounded-xl p-4">
                            <p class="text-sm text-slate-400">📅 Date</p>
                            <p class="font-extrabold text-lg">22 Avril 2026</p>
                        </div>
                        <div class="bg-white/5 border border-white/10 rounded-xl p-4">
                            <p class="text-sm text-slate-400">🕐 Heure</p>
                            <p class="font-extrabold text-lg">18:30</p>
                        </div>
                    </div>
                    <div class="bg-white/5 border border-white/10 rounded-xl p-4 text-center">
                        <p class="text-sm text-slate-400">🏟 Stade</p>
                        <p class="font-extrabold text-lg">Complexe Prince Moulay Abdellah</p>
                    </div>
                    <div class="grid grid-cols-3 gap-4 text-center">
                        <div class="bg-emerald-500/10 border border-emerald-500/30 rounded-xl p-4">
                            <p class="text-sm text-slate-400">Prix</p>
                            <p class="font-extrabold text-xl text-emerald-400">280 MAD</p>
                        </div>
                        <div class="bg-white/5 border border-white/10 rounded-xl p-4">
                            <p class="text-sm text-slate-400">Catégorie</p>
                            <p class="font-bold">Virage</p>
                        </div>
                        <div class="bg-white/5 border border-white/10 rounded-xl p-4">
                            <p class="text-sm text-slate-400">Place</p>
                            <p class="font-bold">B45 - Rang 15</p>
                        </div>
                    </div>
                    <div class="text-center pt-4">
                        <p class="text-xs text-slate-500">Billet n° <span class="font-mono text-emerald-400">TKT-2026-0923</span></p>
                    </div>
                </div>
                <div class="h-1 bg-gradient-to-r from-emerald-500 via-cyan-500 to-emerald-500 opacity-60 group-hover:opacity-100 transition"></div>
            </article>

            <!-- Vous pouvez ajouter autant de tickets statiques que vous voulez ici -->

        </div>

        <!-- Message si aucun ticket (optionnel) -->
        <!-- <div class="text-center py-20">
            <p class="text-slate-300 font-semibold text-lg">Aucun billet pour le moment</p>
            <p class="text-slate-500 mt-2">Réservez vos matchs préférés ! ✨</p>
        </div> -->
    </div>
</main>

<!-- ================= FOOTER ================= -->
<footer class="mt-20 bg-slate-950 border-t border-white/10">
    <div class="max-w-7xl mx-auto px-4 py-10 text-center text-slate-500">
        &copy; 2025 BuyMatch – Réservation de billets sportifs
    </div>
</footer>

<script>
function logout() {
    if (confirm("Voulez-vous vraiment vous déconnecter ?")) {
        window.location.href = "../logout.php";
    }
}
</script>

</body>
</html>
