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
$billetsDejaAchetes = $acheteur->getNbBilletsAchetesPourMatch($matchId);
$maxBilletsParAcheteur = 4;
$peutEncoreAcheter = ($billetsDejaAchetes < $maxBilletsParAcheteur);

$message = $_SESSION['message'] ?? null;
unset($_SESSION['message']);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Acheter un billet | BuyMatch</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        emerald: {
                            50: '#ecfdf5',
                            100: '#d1fae5',
                            500: '#10b981',
                            600: '#059669',
                            700: '#047857'
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-slate-50 text-slate-800">

<!-- ================= NAVBAR ================= -->
<nav class="sticky top-0 z-50 bg-slate-900 text-white shadow-xl backdrop-blur-sm">
    <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
        <div class="flex items-center gap-3 text-2xl font-extrabold">
            <span>🎫</span> BuyMatch
        </div>
        <a href="matches.php" class="px-6 py-3 bg-slate-800 rounded-xl hover:bg-slate-700 transition font-semibold">
            ← Retour aux matchs
        </a>
    </div>
</nav>

<!-- ================= HERO ================= -->
<section class="bg-gradient-to-br from-slate-900 via-emerald-900 to-slate-900 text-white py-20">
    <div class="max-w-7xl mx-auto px-6 text-center">
        <h1 class="text-5xl font-extrabold mb-4">Acheter un billet</h1>
        <p class="text-2xl text-emerald-300">
            <?= htmlspecialchars($match->equipe1->nom) ?> <span class="text-emerald-500">VS</span> <?= htmlspecialchars($match->equipe2->nom) ?>
        </p>
    </div>
</section>

<!-- ================= MAIN CONTENT ================= -->
<main class="py-16">
    <div class="max-w-4xl mx-auto px-6">

        <!-- Match Card -->
        <div class="bg-white rounded-2xl shadow-2xl p-10 mb-10 border border-slate-200">
            <div class="flex justify-center items-center gap-12 mb-8">
                <div class="text-center">
                    <img src="<?= htmlspecialchars($match->equipe1->logo) ?>" alt="<?= htmlspecialchars($match->equipe1->nom) ?>" class="w-28 h-28 mx-auto rounded-full shadow-lg object-contain bg-white p-2">
                    <p class="text-2xl font-extrabold mt-4"><?= htmlspecialchars($match->equipe1->nom) ?></p>
                </div>

                <div class="text-5xl font-bold text-emerald-500">VS</div>

                <div class="text-center">
                    <img src="<?= htmlspecialchars($match->equipe2->logo) ?>" alt="<?= htmlspecialchars($match->equipe2->nom) ?>" class="w-28 h-28 mx-auto rounded-full shadow-lg object-contain bg-white p-2">
                    <p class="text-2xl font-extrabold mt-4"><?= htmlspecialchars($match->equipe2->nom) ?></p>
                </div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
                <div class="bg-emerald-50 rounded-xl p-5 border border-emerald-200">
                    <p class="text-sm text-emerald-600">📅 Date</p>
                    <p class="font-bold text-lg"><?= htmlspecialchars($match->date_match) ?></p>
                </div>
                <div class="bg-emerald-50 rounded-xl p-5 border border-emerald-200">
                    <p class="text-sm text-emerald-600">🕐 Heure</p>
                    <p class="font-bold text-lg"><?= htmlspecialchars($match->heure) ?></p>
                </div>
                <div class="bg-emerald-50 rounded-xl p-5 border border-emerald-200">
                    <p class="text-sm text-emerald-600">⏱ Durée</p>
                    <p class="font-bold text-lg"><?= $match->duree ?> min</p>
                </div>
                <div class="bg-emerald-50 rounded-xl p-5 border border-emerald-200">
                    <p class="text-sm text-emerald-600">🏟 Stade</p>
                    <p class="font-bold text-lg"><?= htmlspecialchars($match->stade) ?></p>
                </div>
            </div>
        </div>

        <!-- Message -->
        <?php if ($message): ?>
            <div class="mb-8 p-5 rounded-xl text-center font-bold text-lg <?= $message[0] === 'success' ? 'bg-green-100 text-green-700 border border-green-300' : 'bg-red-100 text-red-700 border border-red-300' ?>">
                <?= $message[1] ?>
            </div>
        <?php endif; ?>

        <!-- Formulaire d'achat -->
        <div class="bg-white rounded-2xl shadow-2xl p-10 border border-slate-200">
            <h2 class="text-3xl font-extrabold text-center mb-8 text-slate-800">Choisissez votre billet</h2>

            <?php 
            $hasAvailableCategory = false;
            foreach ($match->categories as $c) {
                $vendus = $c->getNbBilletsVendus($matchId); // À implémenter (voir plus bas)
                $disponibles = $c->nb_place - $vendus;
                if ($disponibles > 0) {
                    $hasAvailableCategory = true;
                }
            }
            ?>

            <?php if (!$hasAvailableCategory): ?>
                <div class="text-center py-12">
                    <p class="text-2xl font-bold text-red-600 mb-4">😔 Match complet</p>
                    <p class="text-lg text-slate-600">Toutes les catégories sont épuisées.</p>
                </div>
            <?php elseif (!$peutEncoreAcheter): ?>
                <div class="text-center py-12">
                    <p class="text-2xl font-bold text-orange-600 mb-4">Limite atteinte</p>
                    <p class="text-lg text-slate-600">Vous avez déjà acheté <?= $billetsDejaAchetes ?> billet(s) pour ce match (maximum 4).</p>
                </div>
            <?php else: ?>
                <form method="POST" action="../../php/achteur/acheterBilletProcess.php" class="space-y-8">
                    <input type="hidden" name="id_match" value="<?= $matchId ?>">
                    <input type="hidden" id="nomCategory" name="nom_category">
                    <input type="hidden" id="idCategory" name="id_category">
                    <input type="hidden" id="prix" name="prix">

                    <!-- Catégorie -->
                    <div>
                        <label class="block text-lg font-semibold mb-3 text-slate-700">🎟 Catégorie de billet</label>
                        <select id="categorie" name="categorie" required class="w-full px-5 py-4 text-lg border-2 border-slate-300 rounded-xl focus:border-emerald-500 focus:ring-4 focus:ring-emerald-100 transition">
                            <?php foreach ($match->categories as $c): 
                                $vendus = $c->getNbBilletsVendus($matchId);
                                $disponibles = $c->nb_place - $vendus;
                                $isFull = $disponibles <= 0;
                            ?>
                                <option value="<?= $c->prix ?>" 
                                        data-prix="<?= $c->prix ?>" 
                                        data-id="<?= $c->id_category ?>" 
                                        data-nom="<?= htmlspecialchars($c->nom) ?>"
                                        data-disponibles="<?= $disponibles ?>"
                                        data-total="<?= $c->nb_place ?>"
                                        <?= $isFull ? 'disabled' : '' ?>>
                                    <?= htmlspecialchars($c->nom) ?> - <?= number_format($c->prix, 2) ?> MAD 
                                    (<?= $disponibles ?> / <?= $c->nb_place ?> places)
                                    <?= $isFull ? ' [Complet]' : '' ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <p id="dispoText" class="mt-3 text-lg font-medium"></p>
                    </div>

                    <!-- Numéro de place -->
                    <div>
                        <label class="block text-lg font-semibold mb-3 text-slate-700">🪑 Numéro de place</label>
                        <input type="number" name="place" min="1" max="9999" required placeholder="Ex: 42" 
                               class="w-full px-5 py-4 text-lg border-2 border-slate-300 rounded-xl focus:border-emerald-500 focus:ring-4 focus:ring-emerald-100 transition">
                        <p class="text-sm text-slate-500 mt-2">Choisissez un numéro disponible dans la catégorie sélectionnée.</p>
                    </div>

                    <!-- Prix total -->
                    <div class="bg-emerald-50 border-2 border-emerald-200 rounded-xl p-6 text-center">
                        <p class="text-lg font-semibold text-slate-700 mb-2">Prix total</p>
                        <p class="text-4xl font-extrabold text-emerald-600" id="prixTotal">0.00 MAD</p>

                    </div>

                    <!-- Bouton d'achat -->
                    <button type="submit" id="btnAcheter" 
                            class="w-full py-5 bg-emerald-600 hover:bg-emerald-700 disabled:bg-gray-400 disabled:cursor-not-allowed text-white rounded-xl font-extrabold text-xl transition shadow-lg">
                        ✅ Confirmer l'achat
                    </button>
                </form>
            <?php endif; ?>
        </div>
    </div>
</main>

<!-- ================= FOOTER ================= -->
<footer class="bg-slate-900 text-white py-12 mt-20">
    <div class="text-center text-slate-400">
        © 2026 BuyMatch – Réservation de billets sportifs
    </div>
</footer>

<script>
    const select = document.getElementById('categorie');
    const prixTotal = document.getElementById('prixTotal');
    const prixI = document.getElementById('prix');
    const dispoText = document.getElementById('dispoText');
    const btnAcheter = document.getElementById('btnAcheter');

    function updateUI() {
        const option = select.options[select.selectedIndex];
        const prix = parseFloat(option.dataset.prix || 0);
        const disponibles = parseInt(option.dataset.disponibles || 0);
        const total = parseInt(option.dataset.total || 0);
        document.getElementById('nomCategory').value = option.dataset.nom;
        document.getElementById('idCategory').value = option.dataset.id;
        prixTotal.textContent = prix.toFixed(2) + ' MAD';
        prixI.value = prix.toFixed(2)
        let message = `${disponibles} / ${total} places disponibles`;
        let color = 'text-emerald-600';

        if (disponibles <= 0) {
            color = 'text-red-600';
            message = 'Catégorie complète';
        } else if (disponibles <= 5) {
            color = 'text-orange-600';
            message = `Plus que ${disponibles} place(s) !`;
        }

        dispoText.innerHTML = `<span class="${color} font-bold">${message}</span>`;
        btnAcheter.disabled = (disponibles <= 0);
    }

    select.addEventListener('change', updateUI);
    updateUI();
</script>

</body>
</html>