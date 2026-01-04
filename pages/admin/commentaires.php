<?php
session_start();
require_once "../classes/Administrateur.php";
$admin = Administrateur::getAdminConnected();
$comments = $admin->getAllComments();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-black text-white p-10">

<h2 class="text-3xl font-bold mb-6">Commentaires</h2>

<?php foreach ($comments as $c): ?>
<div class="bg-white/10 p-6 rounded-xl mb-4">
    <p class="font-bold"><?= $c['nom'] ?> <?= $c['prenom'] ?></p>
    <p class="text-gray-300"><?= $c['contenu'] ?></p>
    <p class="text-xs text-gray-500 mt-2"><?= $c['date_creation'] ?></p>
</div>
<?php endforeach; ?>

</body>
</html>
