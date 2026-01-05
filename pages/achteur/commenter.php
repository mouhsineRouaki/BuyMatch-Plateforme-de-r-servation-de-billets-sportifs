<?php
session_start();
require_once "../classes/Achteur.php";
$a = Achteur::getAcheteurConnected();

if ($_POST) {
    $a->addComment($_POST);
    header("Location: mesBillets.php");
}
?>

<form method="post" class="max-w-xl mx-auto bg-white p-8 rounded-xl shadow mt-20">
    <input type="hidden" name="match_id" value="<?= $_GET['match'] ?>">

    <textarea name="contenu" class="w-full border p-4 rounded mb-4"
              placeholder="Votre commentaire"></textarea>

    <select name="note" class="w-full border p-3 rounded mb-4">
        <option value="5">⭐⭐⭐⭐⭐</option>
        <option value="4">⭐⭐⭐⭐</option>
        <option value="3">⭐⭐⭐</option>
        <option value="2">⭐⭐</option>
        <option value="1">⭐</option>
    </select>

    <button class="bg-green-600 text-white w-full py-3 rounded">
        Envoyer
    </button>
</form>
