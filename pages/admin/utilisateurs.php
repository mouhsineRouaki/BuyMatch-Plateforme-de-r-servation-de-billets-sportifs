<?php
session_start();
require_once "../../classes/Administrateur.php";
$admin = Administrateur::getAdminConnected();
$users = $admin->getAllUsers();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Admin – Utilisateurs | BuyMatch</title>
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
            <li><a href="utilisateurs.php" class="text-green-500">Utilisateurs</a></li>
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
<section class="bg-gradient-to-r from-gray-900 to-gray-800 text-white py-12">
    <div class="max-w-7xl mx-auto px-4">
        <h1 class="text-4xl font-bold mb-2">Gestion des utilisateurs</h1>
        <p class="text-gray-300">
            Activez ou désactivez les comptes de la plateforme BuyMatch
        </p>
    </div>
</section>

<!-- ================= CONTENT ================= -->
<section class="py-16 bg-gray-50 min-h-screen">
<div class="max-w-7xl mx-auto px-4">

    <div class="bg-white rounded-xl shadow-lg p-8">

        <?php if (empty($users)): ?>
            <p class="text-center text-gray-500 font-semibold">
                Aucun utilisateur trouvé
            </p>
        <?php endif; ?>

        <div class="space-y-6">
            <?php foreach ($users as $u): ?>
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center
                            gap-6 p-6 border border-gray-200 rounded-xl hover:shadow-lg transition">

                    <!-- ================= USER INFO ================= -->
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-green-600 rounded-full flex items-center justify-center
                                    text-white font-bold text-lg">
                            <?= strtoupper(substr($u['nom'], 0, 1)) ?>
                        </div>

                        <div>
                            <p class="font-bold text-lg">
                                <?= htmlspecialchars($u['nom']) ?>
                                <?= htmlspecialchars($u['prenom']) ?>
                            </p>
                            <p class="text-gray-600 text-sm">
                                <?= htmlspecialchars($u['email']) ?>
                            </p>
                            <p class="text-sm mt-1">
                                <span class="font-semibold">Rôle :</span>
                                <span class="px-2 py-1 rounded text-xs font-bold
                                    <?= $u['role'] === 'ADMINISTRATEUR' ? 'bg-purple-100 text-purple-700' :
                                        ($u['role'] === 'ORGANISATEUR' ? 'bg-blue-100 text-blue-700' :
                                        'bg-gray-100 text-gray-700') ?>">
                                    <?= $u['role'] ?>
                                </span>
                            </p>
                        </div>
                    </div>

                    <!-- ================= ACTION ================= -->
                    <form method="post" action="../../php/Administrateur/toggleUser.php">
                        <input type="hidden" name="id" value="<?= $u['id_user'] ?>">
                        <input type="hidden" name="status" value="<?= $u['actif'] ? 0 : 1 ?>">

                        <button type="submit"
                            class="px-6 py-3 rounded-lg font-semibold text-white transition
                            <?= $u['actif']
                                ? 'bg-red-600 hover:bg-red-700'
                                : 'bg-green-600 hover:bg-green-700' ?>">
                            <?= $u['actif'] ? 'Désactiver' : 'Activer' ?>
                        </button>
                    </form>

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
