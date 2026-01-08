<?php
session_start();
require_once "../../classes/Achteur.php";
require_once "../../classes/Billet.php";

$acheteur = Achteur::getAcheteurConnected();
$billets = $acheteur->getMyBillets();

$today = date('Y-m-d');
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mes billets réservés | BuyMatch</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .star { cursor: pointer; font-size: 1.8rem; transition: color 0.2s; }
        .star:hover, .star.selected { color: #facc15; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800">

<!-- NAVBAR -->
<nav class="sticky top-0 z-50 bg-slate-950/90 backdrop-blur border-b border-white/10">
    <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
        <div class="flex items-center gap-3 text-2xl font-extrabold tracking-tight">
            <span class="text-3xl">🎫</span>
            <span>BuyMatch</span>
        </div>

        <ul class="hidden md:flex gap-8 font-semibold text-slate-200">
            <li><a href="dashboard.php" class="hover:text-emerald-400 transition">Dashboard</a></li>
            <li><a href="matchs.php" class="hover:text-emerald-400">Matchs</a></li>
            <li><a href="mesBillets.php" class="hover:text-emerald-400  text-emerald-400 underline transition underline-offset-4">Mes billets</a></li>
            <li><a href="../profil.php" class="hover:text-emerald-400 transition">Profil</a></li>
        </ul>

        <button onclick="logout()"
                class="px-5 py-2.5 bg-rose-600 rounded-xl hover:bg-rose-700 transition font-semibold shadow-lg">
            Déconnexion
        </button>
    </div>
</nav>

<!-- HERO -->
<section class="bg-gradient-to-br from-slate-900 via-emerald-900 to-slate-900 text-white py-20">
    <div class="max-w-7xl mx-auto px-6 text-center">
        <h1 class="text-5xl font-extrabold mb-4">Mes billets réservés</h1>
        <p class="text-xl text-emerald-300">Tous vos billets achetés et prêts à l'emploi</p>
    </div>
</section>

<main class="py-16">
    <div class="max-w-7xl mx-auto px-6">

        <?php if (empty($billets)): ?>
            <div class="text-center py-20 bg-white rounded-2xl shadow-lg">
                <p class="text-2xl font-bold text-slate-600">Aucun billet réservé pour le moment</p>
                <p class="text-lg text-slate-500 mt-4">Parcourez les matchs et réservez vos places ! ✨</p>
                <a href="matchs.php" class="mt-6 inline-block px-8 py-4 bg-emerald-600 text-white rounded-xl font-bold hover:bg-emerald-700 transition">
                    Voir les matchs disponibles
                </a>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php foreach ($billets as $billet): 
                    $match = $billet->getMatch();
                    $category = $billet->getCategory();
                    $isPassed = $billet->isMatchPassed();
                ?>
                    <article class="bg-white rounded-2xl shadow-2xl overflow-hidden border border-slate-200 hover:shadow-emerald-500/20 transition-all duration-300">
                        <!-- Header match -->
                        <div class="bg-gradient-to-br from-slate-900 to-emerald-900 text-white p-6">
                            <div class="flex items-center justify-between gap-4">
                                <div class="flex-1 text-center">
                                    <img src="<?= htmlspecialchars($match->equipe1->logo) ?>" alt="" class="w-16 h-16 mx-auto rounded-full object-contain bg-white/10 p-1">
                                    <p class="font-extrabold text-lg mt-2"><?= htmlspecialchars($match->equipe1->nom) ?></p>
                                </div>
                                <div class="text-3xl font-bold text-emerald-400">VS</div>
                                <div class="flex-1 text-center">
                                    <img src="<?= htmlspecialchars($match->equipe2->logo) ?>" alt="" class="w-16 h-16 mx-auto rounded-full object-contain bg-white/10 p-1">
                                    <p class="font-extrabold text-lg mt-2"><?= htmlspecialchars($match->equipe2->nom) ?></p>
                                </div>
                            </div>
                            <div class="grid grid-cols-3 gap-2 mt-6 text-center text-sm">
                                <div class="bg-white/10 rounded-lg p-3">
                                    <p class="text-emerald-300">Date</p>
                                    <p class="font-bold"><?= htmlspecialchars($match->date_match) ?></p>
                                </div>
                                <div class="bg-white/10 rounded-lg p-3">
                                    <p class="text-emerald-300">Heure</p>
                                    <p class="font-bold"><?= htmlspecialchars($match->heure) ?></p>
                                </div>
                                <div class="bg-white/10 rounded-lg p-3">
                                    <p class="text-emerald-300">Stade</p>
                                    <p class="font-bold"><?= htmlspecialchars($match->stade) ?></p>
                                </div>
                            </div>
                        </div>

                        <!-- Détails billet -->
                        <div class="p-6 space-y-4">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm text-slate-500">Catégorie</p>
                                    <p class="font-bold text-lg"><?= htmlspecialchars($category->nom) ?></p>
                                </div>
                                <div>
                                    <p class="text-sm text-slate-500">Place</p>
                                    <p class="font-bold text-lg text-emerald-600">#<?= $billet->place ?></p>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm text-slate-500">Prix payé</p>
                                    <p class="font-bold text-xl text-emerald-600"><?= number_format($billet->prix, 2) ?> MAD</p>
                                </div>
                                <div>
                                    <p class="text-sm text-slate-500">Date d'achat</p>
                                    <p class="font-bold"><?= date('d/m/Y', strtotime($billet->date_achat)) ?></p>
                                </div>
                            </div>
                            <div class="text-center pt-4">
                                <p class="text-xs text-slate-500">Référence : <span class="font-mono text-emerald-600"><?= $billet->QRCode ?></span></p>
                            </div>

                            <!-- Statut -->
                            <?php if ($isPassed): ?>
                                <div class="bg-amber-50 border border-amber-300 rounded-xl p-4 text-center">
                                    <p class="font-bold text-amber-700">Match passé</p>
                                </div>
                            <?php else: ?>
                                <div class="bg-emerald-50 border border-emerald-300 rounded-xl p-4 text-center">
                                    <p class="font-bold text-emerald-700">Match à venir</p>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="bg-slate-50 p-6 border-t border-slate-200 flex gap-3">
                            <?php if ($billet->pdfExists()): ?>
                                <a href="../../tickets/ticket_<?= $billet->QRCode ?>.pdf" download
                                   class="flex-1 py-3 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-bold text-center transition shadow">
                                    📥 Télécharger PDF
                                </a>
                            <?php else: ?>
                                <button disabled class="flex-1 py-3 bg-gray-400 text-white rounded-xl font-bold cursor-not-allowed">
                                    PDF non disponible
                                </button>
                            <?php endif; ?>

                            <?php if ($isPassed): ?>
                                <button onclick="openCommentModal(<?= $match->id_match ?>, '<?= addslashes($match->equipe1->nom . ' vs ' . $match->equipe2->nom) ?>')"
                                        class="flex-1 py-3 bg-slate-700 hover:bg-slate-800 text-white rounded-xl font-bold transition shadow">
                                    ⭐ Laisser un avis
                                </button>
                            <?php endif; ?>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</main>

<!-- Modal Commentaire -->
<div id="commentModal" class="fixed inset-0 bg-black/60 hidden flex items-center justify-center z-50">
    <div class="bg-white rounded-2xl shadow-2xl p-8 max-w-lg w-full mx-4">
        <h3 class="text-2xl font-extrabold mb-4">Votre avis sur le match</h3>
        <p id="modalMatchName" class="text-lg text-slate-600 mb-6"></p>

        <form method="POST" action="../../php/achteur/addCommentProcess.php">
            <input type="hidden" name="id_match" id="modalMatchId">

            <div class="mb-6">
                <label class="block text-lg font-semibold mb-3">Note (1 à 5 étoiles)</label>
                <div class="flex gap-2 justify-center">
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                        <span class="star" data-value="<?= $i ?>" onclick="selectStars(<?= $i ?>)">⭐</span>
                    <?php endfor; ?>
                </div>
                <input type="hidden" name="note" id="selectedRating" value="0" required>
                <p class="text-center mt-3 text-slate-600">Cliquez sur les étoiles pour noter</p>
            </div>

            <div class="mb-6">
                <label class="block text-lg font-semibold mb-3">Votre commentaire</label>
                <textarea name="contenu" rows="4" required placeholder="Partagez votre expérience..." 
                          class="w-full px-4 py-3 border-2 border-slate-300 rounded-xl focus:border-emerald-500 focus:ring-4 focus:ring-emerald-100"></textarea>
            </div>

            <div class="flex gap-4">
                <button type="submit" class="flex-1 py-3 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-bold transition">
                    Envoyer l'avis
                </button>
                <button type="button" onclick="closeCommentModal()" class="flex-1 py-3 bg-slate-300 hover:bg-slate-400 text-slate-800 rounded-xl font-bold transition">
                    Annuler
                </button>
            </div>
        </form>
    </div>
</div>

<footer class="bg-slate-900 text-white py-12 mt-20">
    <div class="text-center text-slate-400">
        © 2026 BuyMatch – Réservation de billets sportifs
    </div>
</footer>

<script>
function openCommentModal(matchId, matchName) {
    document.getElementById('modalMatchId').value = matchId;
    document.getElementById('modalMatchName').textContent = matchName;
    document.getElementById('commentModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeCommentModal() {
    document.getElementById('commentModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
    document.getElementById('selectedRating').value = 0;
    document.querySelectorAll('.star').forEach(s => s.classList.remove('selected'));
}

function selectStars(value) {
    document.getElementById('selectedRating').value = value;
    document.querySelectorAll('.star').forEach((star, i) => {
        star.classList.toggle('selected', i < value);
    });
}
</script>

</body>
</html>