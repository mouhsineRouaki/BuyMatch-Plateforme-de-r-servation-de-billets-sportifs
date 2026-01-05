<?php
session_start();
require_once "../../classes/Administrateur.php";
$admin = Administrateur::getAdminConnected();
$comments = $admin->getAllComments();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Admin – Commentaires | BuyMatch</title>
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
            <li><a href="demandesMatchs.php" class="hover:text-green-500 transition">Demandes de matchs</a></li>
            <li><a href="commentaires.php" class="text-green-500">Commentaires</a></li>
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
        <h1 class="text-4xl font-bold mb-2">Commentaires utilisateurs</h1>
        <p class="text-gray-300">
            Consultez les avis et retours laissés sur la plateforme
        </p>
    </div>
</section>

<!-- ================= CONTENT ================= -->
<section class="py-16 bg-gray-50 min-h-screen">
<div class="max-w-7xl mx-auto px-4">

    <div class="bg-white rounded-xl shadow-lg p-8">

        <?php if (empty($comments)): ?>
            <p class="text-center text-gray-500 font-semibold">
                Aucun commentaire disponible
            </p>
        <?php endif; ?>

        <div class="space-y-6">
            <?php foreach ($comments as $c): ?>
                <div class="border border-gray-200 rounded-xl p-6 hover:shadow-lg transition">

                    <!-- ================= USER ================= -->
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-12 h-12 bg-green-600 rounded-full flex items-center justify-center
                                    text-white font-bold text-lg">
                            <?= strtoupper(substr($c['nom'], 0, 1)) ?>
                        </div>

                        <div>
                            <p class="font-bold text-lg">
                                <?= htmlspecialchars($c['nom']) ?>
                                <?= htmlspecialchars($c['prenom']) ?>
                            </p>
                            <p class="text-sm text-gray-500">
                                🕒 <?= $c['date_creation'] ?>
                            </p>
                        </div>
                    </div>

                    <!-- ================= COMMENT ================= -->
                    <div class="bg-gray-50 rounded-lg p-4 text-gray-700 leading-relaxed">
                        <?= nl2br(htmlspecialchars($c['contenu'])) ?>
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
        window.location.href = "../index.php";
    }
}
</script>

</body>
</html>
