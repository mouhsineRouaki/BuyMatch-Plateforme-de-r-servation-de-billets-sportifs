<?php
session_start();
require_once "../../classes/Administrateur.php";
$admin = Administrateur::getAdminConnected();
$matchs = $admin->getMatchRequests();

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Admin – Demandes de matchs | BuyMatch</title>
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
            <li><a href="dashboard.php" class="hover:text-green-500 transition">Dashboard</a></li>
            <li><a href="utilisateurs.php" class="hover:text-green-500 transition">Utilisateurs</a></li>
            <li><a href="demandesMatchs.php" class="text-green-500">Demandes de matchs</a></li>
            <li><a href="commentaires.php" class="hover:text-green-500 transition">Commentaires</a></li>
        </ul>

        <button onclick="logout()"
                class="px-4 py-2 bg-red-600 rounded hover:bg-red-700 transition">
            Déconnexion
        </button>
    </div>
</nav>

<!-- ================= HERO ================= -->
<section class="bg-gradient-to-r from-gray-900 to-gray-800 text-white py-12">
    <div class="max-w-7xl mx-auto px-4">
        <h1 class="text-4xl font-bold mb-2">Demandes de matchs</h1>
        <p class="text-gray-300">
            Validation des matchs proposés par les organisateurs
        </p>
    </div>
</section>

<!-- ================= CONTENT ================= -->
<section class="py-16 bg-gray-50 min-h-screen">
<div class="max-w-7xl mx-auto px-4">

    <div class="bg-white rounded-xl shadow-lg p-8">
        <?php if (empty($matchs)): ?>
            <p class="text-center text-gray-500 font-semibold">
                Aucune demande de match en attente
            </p>
        <?php endif; ?>

        <div class="space-y-8">
            <?php foreach ($matchs as $m): ?>
                <?php 
                 $listNom = explode(',' ,$m['nom']);
                 $listLogo = explode(',' ,$m['logo']);
                ?>
                <div class="border border-gray-200 rounded-xl p-6 hover:shadow-lg transition">

                    <!-- ================= MATCH HEADER ================= -->
                    <div class="flex flex-col lg:flex-row justify-between gap-6">

                        <!-- ===== TEAMS ===== -->
                        <div class="flex items-center gap-6 flex-1">

                            <!-- Équipe 1 -->
                            <div class="flex items-center gap-3">
                                <img src="<?= $listLogo[0] ?? '../../assets/team.png' ?>"
                                     class="w-14 h-14 object-contain"
                                     alt="Logo équipe 1">
                                <span class="font-bold text-lg">
                                    <?= htmlspecialchars($listNom[0]) ?>
                                </span>
                            </div>

                            <span class="text-gray-400 font-bold text-xl">VS</span>

                            <!-- Équipe 2 -->
                            <div class="flex items-center gap-3">
                                <img src="<?= $listLogo[1] ?? '../../assets/team.png' ?>"
                                     class="w-14 h-14 object-contain"
                                     alt="Logo équipe 2">
                                <span class="font-bold text-lg">
                                    <?= htmlspecialchars($listNom[1]) ?>
                                </span>
                            </div>
                        </div>

                        <!-- ===== ACTIONS ===== -->
                        <div class="flex gap-4">
                            <a href="updateMatch.php?id=<?= $m['id_match'] ?>&status=accepte"
                               class="px-6 py-3 bg-green-600 text-white rounded-lg font-semibold
                                      hover:bg-green-700 transition">
                                Accepter
                            </a>

                            <a href="updateMatch.php?id=<?= $m['id_match'] ?>&status=refuse"
                               class="px-6 py-3 bg-red-600 text-white rounded-lg font-semibold
                                      hover:bg-red-700 transition">
                                Refuser
                            </a>
                        </div>
                    </div>

                    <!-- ================= MATCH INFOS ================= -->
                    <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4 text-sm text-gray-600">

                        <div class="flex items-center gap-2">
                            📅 <span class="font-semibold"><?= $m['date_match'] ?></span>
                        </div>

                        <div class="flex items-center gap-2">
                            🕐 <span class="font-semibold"><?= $m['heure'] ?></span>
                        </div>

                        <div class="flex items-center gap-2">
                            ⏱️ <span class="font-semibold"><?= $m['duree'] ?> min</span>
                        </div>

                    </div>

                    <!-- ================= STATUS ================= -->
                    <div class="mt-4">
                        <span class="inline-block px-4 py-1 text-sm font-semibold rounded-full
                                     bg-yellow-100 text-yellow-700">
                            En attente de validation
                        </span>
                    </div>

                </div>
            <?php endforeach; ?>
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
