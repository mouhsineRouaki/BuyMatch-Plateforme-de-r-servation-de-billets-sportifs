<?php
require_once "../../config/Database.php";
require_once "../../classes/Equipe.php";
$equipes = Equipe::getEquipes()
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>BuyMatch – Créer un Match</title>
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
                <a href="dashbord.php"
                   class="hover:text-green-400 transition border-b-2 border-transparent hover:border-green-400">
                    Dashboard
                </a>
            </li>
            <li>
                <a href="#"
                   class="text-green-400 border-b-2 border-green-400">
                    Créer un match
                </a>
            </li>
            <li>
                <a href="../profil.php"
                   class="hover:text-green-400 transition border-b-2 border-transparent hover:border-green-400">
                    Profil
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
<section class="pt-32 pb-24 text-center bg-[radial-gradient(ellipse_at_top,_var(--tw-gradient-stops))] from-green-600/30 via-transparent to-transparent">
    <div class="max-w-5xl mx-auto px-6">
        <h1 class="text-5xl font-extrabold mb-6 leading-tight">
            Créez un Match de Football
        </h1>
        <p class="text-gray-300 text-lg">
            Configurez les équipes, horaires et billets comme une plateforme professionnelle
        </p>
    </div>
</section>

<!-- ================= FORM ================= -->
<section class="py-20">
<div class="max-w-4xl mx-auto px-6">
<div class="bg-white/10 backdrop-blur-xl rounded-3xl shadow-2xl p-10">

<form method="POST" action="../../php/process_creer_match.php" onsubmit="return validateTeams()">

<!-- ===== ÉQUIPES ===== -->
<div class="mb-12">
    <h3 class="text-2xl font-bold mb-6 flex items-center gap-2">
        ⚔️ Équipes
    </h3>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <select name="equipes[]" id="equipe1" onchange="checkDuplicate()" required
                class="w-full p-4 rounded-xl bg-white text-gray-900 focus:ring-4 focus:ring-green-500">
            <option value="">Équipe domicile</option>
            <?php foreach ($equipes as $e): ?>
                <option value="<?= $e->id?>">
                    <?= htmlspecialchars($e->nom) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <select name="equipes[]" id="equipe2" onchange="checkDuplicate()" required
                class="w-full p-4 rounded-xl bg-white text-gray-900 focus:ring-4 focus:ring-green-500">
            <option value="">Équipe visiteur</option>
            <?php foreach ($equipes as $e): ?>
                <option value="<?= $e->id ?>">
                    <?= htmlspecialchars($e->nom) ?>
                </option>
            <?php endforeach; ?>
        </select>

    </div>

    <p id="teamError" class="hidden mt-4 text-red-400 font-semibold">
        ⚠️ Les équipes doivent être différentes
    </p>
</div>

<!-- ===== DATE / HEURE ===== -->
<div class="mb-12">
    <h3 class="text-2xl font-bold mb-6 flex items-center gap-2">
        🕒 Date & Heure
    </h3>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <input type="date" name="date" required
               class="w-full p-4 rounded-xl bg-white text-gray-900 focus:ring-4 focus:ring-green-500">
        <input type="time" name="heure" required
               class="w-full p-4 rounded-xl bg-white text-gray-900 focus:ring-4 focus:ring-green-500">
        <input type="number" name="duree" placeholder="Durée (min)" required
               class="w-full p-4 rounded-xl bg-white text-gray-900 focus:ring-4 focus:ring-green-500">
    </div>
</div>

<!-- ===== CATÉGORIES ===== -->
<div class="mb-12">
    <h3 class="text-2xl font-bold mb-6 flex items-center gap-2">
        🎫 Catégories de billets
    </h3>

    <div id="categories" class="space-y-4"></div>

    <button type="button" onclick="addCategory()"
            class="mt-4 px-6 py-3 bg-blue-600 rounded-xl hover:bg-blue-700 transition font-semibold">
        + Ajouter une catégorie
    </button>
</div>

<!-- ===== ACTIONS ===== -->
<div class="flex flex-col md:flex-row gap-6">
    <button type="submit"
            class="flex-1 py-4 bg-green-600 rounded-xl font-bold hover:bg-green-700 transition">
        🚀 Créer le match
    </button>

    <a href="dashboard.php"
       class="flex-1 py-4 bg-gray-300 text-center rounded-xl font-bold text-gray-900 hover:bg-gray-400 transition">
        Annuler
    </a>
</div>

</form>
</div>
</div>
</section>

<!-- ================= FOOTER ================= -->
<footer class="bg-black/90 py-10 text-center text-gray-400 border-t border-white/10">
    © 2025 BuyMatch – Football Ticketing Platform
</footer>

<!-- ================= JS ================= -->
<script>
let index = 0;

function addCategory() {
    const div = document.createElement("div");
    div.className =
        "grid grid-cols-1 md:grid-cols-4 gap-4 p-4 rounded-xl bg-white text-gray-900 shadow";

    div.innerHTML = `
        <input name="categories[${index}][nom]" placeholder="Nom catégorie" required
               class="p-3 rounded-lg border focus:ring-2 focus:ring-blue-500">
        <input name="categories[${index}][prix]" type="number" step="0.01" placeholder="Prix" required
               class="p-3 rounded-lg border focus:ring-2 focus:ring-blue-500">
        <input name="categories[${index}][nb_place]" type="number" placeholder="Places" required
               class="p-3 rounded-lg border focus:ring-2 focus:ring-blue-500">
        <button type="button" onclick="this.parentElement.remove()"
                class="bg-red-600 text-white rounded-lg font-bold hover:bg-red-700">
            X
        </button>
    `;
    document.getElementById("categories").appendChild(div);
    index++;
}

function checkDuplicate() {
    teamError.classList.toggle(
        "hidden",
        !(equipe1.value && equipe2.value && equipe1.value === equipe2.value)
    );
}

function validateTeams() {
    if (equipe1.value === equipe2.value) {
        alert("Les équipes doivent être différentes !");
        return false;
    }
    return true;
}

function logout() {
    window.location.href = "../../logout.php";
}
</script>

</body>
</html>
