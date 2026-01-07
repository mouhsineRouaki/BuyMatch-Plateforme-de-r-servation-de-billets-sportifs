<?php
session_start();
require_once "../../classes/Achteur.php";

$acheteur = Achteur::getAcheteurConnected();

if (!isset($_GET['id'])) {
    header("Location: matchs.php");
    exit;
}

$matchId = (int) $_GET['id'];
$match = MatchSport::getMatchById($matchId);

if (!$match) {
    die("Match introuvable");
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Acheter un billet | BuyMatch</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-white text-gray-900">

    <!-- ================= NAVBAR ================= -->
    <nav class="sticky top-0 z-50 bg-gray-900 text-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
            <div class="flex items-center gap-2 text-2xl font-bold">
                🎫 BuyMatch
            </div>
            <a href="matchs.php" class="px-4 py-2 bg-gray-700 rounded hover:bg-gray-600">
                ← Retour
            </a>
        </div>
    </nav>

    <section class="bg-gradient-to-r from-gray-900 to-gray-800 text-white py-14">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <h1 class="text-4xl font-bold mb-2">Acheter un billet</h1>
            <p class="text-gray-300">
                <?= htmlspecialchars($match->equipe1->nom) ?> vs <?= htmlspecialchars($match->equipe2->nom) ?>
            </p>
        </div>
    </section>

    <section class="py-16 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto px-4">

            <div class="bg-white rounded-xl shadow-lg p-8 mb-10">

                <div class="flex justify-center items-center gap-8 mb-6">
                    <div class="text-center">
                        <img src="<?= $match->equipe1->logo ?>" class="w-16 mx-auto">
                        <p class="font-bold mt-2"><?= $match->equipe1->nom ?></p>
                    </div>

                    <span class="text-xl font-bold text-gray-500">VS</span>

                    <div class="text-center">
                        <img src="<?= $match->equipe2->logo ?>" class="w-16 mx-auto">
                        <p class="font-bold mt-2"><?= $match->equipe2->nom ?></p>
                    </div>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-center">
                    <div class="bg-gray-100 rounded-lg p-4">
                        📅 <strong><?= $match->date_match ?></strong>
                    </div>
                    <div class="bg-gray-100 rounded-lg p-4">
                        🕐 <strong><?= $match->heure ?></strong>
                    </div>
                    <div class="bg-gray-100 rounded-lg p-4">
                        ⏱ <strong><?= $match->duree ?> min</strong>
                    </div>
                    <div class="bg-gray-100 rounded-lg p-4">
                        🏟 <strong><?= $match->stade ?></strong>
                    </div>
                </div>
            </div>

            <?php if ($message): ?>
                <div class="mb-6 p-4 rounded-lg text-center font-semibold
             <?= $message[0] === 'success'
                 ? 'bg-green-100 text-green-700'
                 : 'bg-red-100 text-red-700' ?>">
                    <?= $message[1] ?>
                </div>
            <?php endif; ?>

            <!-- ===== FORM ===== -->
            <form method="POST" class="bg-white rounded-2xl shadow-xl p-8 space-y-6" action="../../php/achteur/acheterBilletProcess.php">
                <input type="hidden" name="id_match" value="<?= $matchId ?>">
                <!-- Catégorie -->
                <div>
                    <label class="block font-semibold mb-2">🎟 Catégorie</label>
                    <select id="categorie" name="categorie" required
                        class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-green-500">
                        <?php foreach ($match->categories as $c): ?>
                            <option value="<?= $c->prix ?>" data-prix="<?= $c->prix ?>" data-id="<?= $c->id_category ?>"
                                data-place="<?= $c->nb_place ?>" data-availible="<?= $c->getNbplacAavailible($matchId) ?>">
                                <?= htmlspecialchars($c->nom) ?> – <?= number_format($c->prix, 2) ?> €
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Numéro de place -->
                <div>
                    <label class="block font-semibold mb-2">🪑 Numéro de place</label>
                    <input type="number" name="place" min="1" required
                        class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-green-500"
                        placeholder="Ex: 25">
                    <p id="total_max" class="text-sm text-gray-500 mt-1">Maximum 4 billets par match</p>
                </div>


                <!-- Prix -->
                <div class="bg-gray-100 p-4 rounded-lg">
                    <label class="block font-semibold mb-2">💰 Prix total (€)</label>
                    <input type="number" id="prix" name="prix" readonly
                        class="w-full px-4 py-3 border rounded-lg bg-gray-200 font-bold text-lg">
                </div>

                <!-- Bouton -->
                <button type="submit"
                    class="w-full py-4 bg-green-600 hover:bg-green-700 text-white rounded-xl font-bold text-lg transition">
                    ✅ Confirmer l'achat
                </button>

            </form>


        </div>
    </section>

    <!-- ================= FOOTER ================= -->
    <footer class="bg-gray-900 text-white py-12 border-t-4 border-green-600">
        <div class="text-center text-gray-400">
            © 2025 BuyMatch – Billetterie sportive
        </div>
    </footer>
    <script>
        const categorieSelect = document.getElementById('categorie');
        const prixInput = document.getElementById('prix');
        const placeTotal = document.getElementById('total_max');
        placeTotal.innerHTML = categorieSelect.options[categorieSelect.selectedIndex].dataset.availible + "/" + categorieSelect.options[categorieSelect.selectedIndex].dataset.place + "availible place"

        function calculerPrix() {
            const prixUnitaire = parseFloat(
                categorieSelect.options[categorieSelect.selectedIndex].dataset.prix
            );
            const quantite =  1;
            prixInput.value = (prixUnitaire * quantite).toFixed(2);
        }

        categorieSelect.addEventListener('change', () => {
            calculerPrix();
            placeTotal.innerHTML = categorieSelect.options[categorieSelect.selectedIndex].dataset.availible + "/" + categorieSelect.options[categorieSelect.selectedIndex].dataset.place + " availible place"
        });

        calculerPrix();

    </script>

</body>

</html>