<?php
session_start();
require_once "../classes/Acheteur.php";
$a = Acheteur::getAcheteurConnected();

if ($_POST) {
    $a->buyTicket($_POST);
    header("Location: mesBillets.php");
}
?>

<form method="post" class="max-w-xl mx-auto bg-white p-8 rounded-xl shadow mt-20">
    <input type="hidden" name="match_id" value="<?= $_GET['id'] ?>">
    <input type="hidden" name="prix" value="100">

    <select name="categorie" class="w-full border p-3 rounded mb-4">
        <option>VIP</option>
        <option>Standard</option>
        <option>Économie</option>
    </select>

    <input type="number" name="place" class="w-full border p-3 rounded mb-4"
           placeholder="Numéro de place">

    <button class="bg-green-600 text-white w-full py-3 rounded-lg">
        Acheter
    </button>
</form>
