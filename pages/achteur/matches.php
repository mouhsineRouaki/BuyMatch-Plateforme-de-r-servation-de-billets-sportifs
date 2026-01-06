<?php
session_start();
require_once "../../classes/Achteur.php";
$a = Achteur::getAcheteurConnected();
$matchs = $a->getAvailableMatchs();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Matchs disponibles | BuyMatch</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-white text-gray-900">

<!-- ================= NAVBAR ================= -->
<nav class="sticky top-0 z-50 bg-gray-900 text-white shadow-lg">
    <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
        <div class="flex items-center gap-2 text-2xl font-bold">
            <span>🎫</span>
            <span>BuyMatch</span>
        </div>

        <ul class="hidden md:flex gap-8 font-semibold">
            <li><a href="dashboard.php" class="hover:text-green-500">Dashboard</a></li>
            <li><a href="matchs.php" class="text-green-500">Matchs</a></li>
            <li><a href="mesBillets.php" class="hover:text-green-500">Mes billets</a></li>
            <li><a href="profil.php" class="hover:text-green-500">Profil</a></li>
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
        <h1 class="text-4xl font-bold mb-2">Matchs disponibles</h1>
        <p class="text-gray-300">
            Choisissez un match et réservez vos billets
        </p>
    </div>
</section>

<!-- ================= MATCH LIST ================= -->
<section class="py-16 bg-gray-50 min-h-screen">
<div class="max-w-7xl mx-auto px-4">

    <?php if (empty($matchs)): ?>
        <p class="text-center text-gray-500 font-semibold">
            Aucun match disponible pour le moment
        </p>
    <?php endif; ?>

    <div class="grid grid-cols-1 gap-8">
        <?php foreach ($matchs as $m): ?>
        <div class="bg-white rounded-xl shadow-lg hover:shadow-2xl transition p-8">

            <!-- ===== TEAMS ===== -->
            <div class="flex flex-col md:flex-row justify-between items-center gap-6">

                <div class="flex items-center gap-6">
                    <!-- Team 1 -->
                    <div class="flex items-center gap-3">
                        <img src="<?= htmlspecialchars($m['logo1']) ?>"
                             alt="logo equipe 1"
                             class="w-14 h-14 object-contain">
                        <span class="font-bold text-lg">
                            <?= htmlspecialchars($m['equipe1']) ?>
                        </span>
                    </div>

                    <span class="text-gray-400 font-bold">VS</span>

                    <!-- Team 2 -->
                    <div class="flex items-center gap-3">
                        <img src="<?= htmlspecialchars($m['logo2']) ?>"
                             alt="logo equipe 2"
                             class="w-14 h-14 object-contain">
                        <span class="font-bold text-lg">
                            <?= htmlspecialchars($m['equipe2']) ?>
                        </span>
                    </div>
                </div>

                <!-- ===== CTA ===== -->
                <a href="acheterBillet.php?id=<?= $m['id'] ?>"
                   class="px-8 py-3 bg-green-600 text-white rounded-lg
                          hover:bg-green-700 transition font-semibold">
                    Acheter un billet
                </a>
            </div>

            <!-- ===== MATCH DETAILS ===== -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mt-8 text-center">

                <div class="bg-gray-50 rounded-lg p-4">
                    <p class="text-sm text-gray-500">Date</p>
                    <p class="font-bold text-lg">📅 <?= $m['date'] ?></p>
                </div>

                <div class="bg-gray-50 rounded-lg p-4">
                    <p class="text-sm text-gray-500">Heure</p>
                    <p class="font-bold text-lg">🕐 <?= $m['heure'] ?></p>
                </div>

                <div class="bg-gray-50 rounded-lg p-4">
                    <p class="text-sm text-gray-500">Durée</p>
                    <p class="font-bold text-lg">⏱ <?= $m['duree'] ?> min</p>
                </div>

                <div class="bg-gray-50 rounded-lg p-4">
                    <p class="text-sm text-gray-500">Stade</p>
                    <p class="font-bold text-lg">🏟 <?= $m['stade'] ?? '—' ?></p>
                </div>

            </div>

        </div>
        <?php endforeach; ?>
    </div>

</div>
</section>

<!-- ================= FOOTER ================= -->
<footer class="bg-gray-900 text-white py-12 border-t-4 border-green-600">
    <div class="max-w-7xl mx-auto px-4 text-center text-gray-400">
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
