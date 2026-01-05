<?php
session_start();
require_once "../../classes/Achteur.php";
$a = Achteur::getAcheteurConnected();
$tickets = $a->getMyTickets();
?>

<section class="max-w-7xl mx-auto py-16 px-6">
<?php foreach ($tickets as $t): ?>
<div class="bg-white p-6 rounded-xl shadow mb-4">
    <p class="font-bold"><?= $t['equipe1'] ?> VS <?= $t['equipe2'] ?></p>
    <p>🎫 Place <?= $t['place'] ?> | <?= $t['categorie'] ?></p>
    <p class="text-sm text-gray-500"><?= $t['date'] ?> – <?= $t['heure'] ?></p>
    <a href="commenter.php?match=<?= $t['match_id'] ?>" class="text-green-600">
        Laisser un avis
    </a>
</div>
<?php endforeach; ?>
</section>
