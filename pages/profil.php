<?php
session_start();
require_once '../classes/Organisateur.php';
require_once '../classes/Achteur.php';
$org = null;
if($_SESSION["role"] === "ACHTEUR"){
    $org = Organisateur::getOrganisateurConnected();
}else{
    $org = Achteur::getAcheteurConnected();
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>BuyMatch – Mon Profil</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-b from-black via-gray-900 to-gray-800 text-white">

<!-- ================= NAVBAR ================= -->
<nav class="fixed top-0 w-full z-50 backdrop-blur bg-black/60 border-b border-white/10">
    <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
        <div class="flex items-center gap-2 text-2xl font-extrabold tracking-wide">
            ⚽ <span>BuyMatch</span>
        </div>

        <ul class="hidden md:flex gap-10 font-semibold">
            <li>
                <a href="organisateur/dashbord.php"
                   class="hover:text-green-400 transition border-b-2 border-transparent hover:border-green-400">
                    Dashboard
                </a>
            </li>
            <li>
                <a href="organisateur/creeDemandeMatch.php"
                   class="hover:text-green-400 transition border-b-2 border-transparent hover:border-green-400">
                    Créer un match
                </a>
            </li>
        </ul>

        <button onclick="logout()"
                class="px-4 py-2 bg-red-600 rounded-lg hover:bg-red-700 transition">
            Déconnexion
        </button>
    </div>
</nav>

<!-- ================= HERO ================= -->
<section class="pt-32 pb-20 text-center bg-[radial-gradient(ellipse_at_top,_var(--tw-gradient-stops))] from-green-600/30 via-transparent to-transparent">
    <div class="max-w-5xl mx-auto px-6">
        <h1 class="text-5xl font-extrabold mb-4">Mon Profil</h1>
        <p class="text-gray-300 text-lg">
            Gérez vos informations personnelles
        </p>
    </div>
</section>

<!-- ================= CONTENT ================= -->
<section class="pb-20">
<div class="max-w-3xl mx-auto px-6">

<div class="bg-white/10 backdrop-blur-xl rounded-3xl shadow-2xl p-10 border border-white/10">

<!-- ================= HEADER ================= -->
<div class="flex items-center gap-6 mb-10 pb-8 border-b border-white/10">
    <div class="w-24 h-24 bg-green-600 rounded-full flex items-center justify-center text-4xl">
        👤
    </div>
    <div>
        <h2 id="displayName" class="text-2xl font-bold">
            <?= $org->nom ?> <?= $org->prenom ?>
        </h2>
        <p id="displayEmail" class="text-gray-300">
            <?= $org->email ?>
        </p>
    </div>
</div>

<!-- ================= FORM ================= -->
<form id="profileForm" class="space-y-6" method="post" action="../php/updateProfil.php">

<div>
    <label class="block text-sm font-semibold text-gray-300 mb-2">Prénom</label>
    <input type="text" id="firstName" name="prenom" value="<?= $org->prenom ?>"
           class="w-full p-4 rounded-xl bg-white text-gray-900 focus:ring-4 focus:ring-green-500">
</div>

<div>
    <label class="block text-sm font-semibold text-gray-300 mb-2">Nom</label>
    <input type="text" id="lastName" name="nom" value="<?= $org->nom ?>"
           class="w-full p-4 rounded-xl bg-white text-gray-900 focus:ring-4 focus:ring-green-500">
</div>

<div>
    <label class="block text-sm font-semibold text-gray-300 mb-2">Email</label>
    <input type="email" id="email" name="email" value="<?= $org->email ?>"
           class="w-full p-4 rounded-xl bg-white text-gray-900 focus:ring-4 focus:ring-green-500">
</div>

<div>
    <label class="block text-sm font-semibold text-gray-300 mb-2">Téléphone</label>
    <input type="tel" id="phone" name="phone" value="<?= $org->phone ?>"
           class="w-full p-4 rounded-xl bg-white text-gray-900 focus:ring-4 focus:ring-green-500">
</div>

<div class="border-t border-white/10 my-8"></div>

<div>
    <label class="block text-sm font-semibold text-gray-300 mb-2">
        Nouveau mot de passe (optionnel)
    </label>
    <input type="password" id="newPassword" name="password"
           class="w-full p-4 rounded-xl bg-white text-gray-900 focus:ring-4 focus:ring-green-500"
           placeholder="Laissez vide si vous ne souhaitez pas le modifier">
    <p class="text-xs text-gray-400 mt-2">Minimum 8 caractères</p>
</div>

<!-- ================= ACTIONS ================= -->
<div class="flex flex-col md:flex-row gap-6 pt-6">
    <button type="submit"
            class="flex-1 py-4 bg-green-600 rounded-xl font-bold hover:bg-green-700 transition">
        Sauvegarder
    </button>
    <button type="button" onclick="resetForm()"
            class="flex-1 py-4 bg-gray-300 text-gray-900 rounded-xl font-bold hover:bg-gray-400 transition">
        Annuler
    </button>
</div>

</form>

<div id="message"
     class="mt-6 hidden px-4 py-3 rounded-xl text-center font-semibold">
</div>

</div>
</div>
</section>

<!-- ================= FOOTER ================= -->
<footer class="bg-black/90 py-10 text-center text-gray-400 border-t border-white/10">
    © 2025 BuyMatch – Football Ticketing Platform
</footer>

<script>
function resetForm() {
    document.getElementById('profileForm').reset();
    document.getElementById('message').classList.add('hidden');
}

function logout() {
    window.location.href = 'indexCopy.html';
}
</script>

</body>
</html>
