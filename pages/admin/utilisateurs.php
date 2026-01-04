<?php
session_start();
require_once "../classes/Administrateur.php";
$admin = Administrateur::getAdminConnected();
$users = $admin->getAllUsers();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-black text-white p-10">

<h2 class="text-3xl font-bold mb-6">Gestion des utilisateurs</h2>

<div class="space-y-4">
<?php foreach ($users as $u): ?>
<div class="bg-white/10 p-6 rounded-xl flex justify-between items-center">
    <div>
        <p class="font-bold"><?= $u['nom'] ?> <?= $u['prenom'] ?></p>
        <p class="text-gray-400"><?= $u['email'] ?> • <?= $u['role'] ?></p>
    </div>

    <form method="post" action="toggleUser.php">
        <input type="hidden" name="id" value="<?= $u['id_user'] ?>">
        <input type="hidden" name="status" value="<?= $u['actif'] ? 0 : 1 ?>">
        <button class="px-4 py-2 rounded-lg <?= $u['actif'] ? 'bg-red-600' : 'bg-green-600' ?>">
            <?= $u['actif'] ? 'Désactiver' : 'Activer' ?>
        </button>
    </form>
</div>
<?php endforeach; ?>
</div>

</body>
</html>
