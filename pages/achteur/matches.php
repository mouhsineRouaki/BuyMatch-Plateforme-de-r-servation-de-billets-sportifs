<?php
session_start();
require_once "../classes/Acheteur.php";
$a = Acheteur::getAcheteurConnected();
$matchs = $a->getAvailableMatchs();
?>

<!DOCTYPE html>
<html>
<head>
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50">

<section class="max-w-7xl mx-auto py-16 px-6">
<?php foreach ($matchs as $m): ?>
<div class="bg-white p-6 rounded-xl shadow mb-6 flex justify-between items-center">
    <div class="flex items-center gap-6">
        <img src="<?= $m['logo1'] ?>" class="w-12">
        <strong><?= $m['equipe1'] ?></strong>
        <span>VS</span>
        <img src="<?= $m['logo2'] ?>" class="w-12">
        <strong><?= $m['equipe2'] ?></strong>
    </div>

    <a href="acheterBillet.php?id=<?= $m['id'] ?>"
       class="bg-green-600 text-white px-6 py-2 rounded">
       Acheter
    </a>
</div>
<?php endforeach; ?>
</section>

</body>
</html>
