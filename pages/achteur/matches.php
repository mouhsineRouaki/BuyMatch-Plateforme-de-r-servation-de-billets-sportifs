<?php
session_start();
require_once "../../classes/Achteur.php";
$a = Achteur::getAcheteurConnected();
$matchs = $a->getAvailableMatchs();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Matchs disponibles | BuyMatch</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        emerald: {
                            400: '#34d399',
                            500: '#10b981',
                        }
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-slate-950 text-slate-100 min-h-screen">

<!-- ================= NAVBAR ================= -->
<nav class="sticky top-0 z-50 bg-slate-950/90 backdrop-blur border-b border-white/10">
    <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
        <div class="flex items-center gap-3 text-2xl font-extrabold tracking-tight">
            <span class="text-3xl">🎫</span>
            <span>BuyMatch</span>
        </div>

        <ul class="hidden md:flex gap-8 font-semibold text-slate-200">
            <li><a href="dashboard.php" class="hover:text-emerald-400 transition">Dashboard</a></li>
            <li><a href="matchs.php" class="text-emerald-400 underline underline-offset-4">Matchs</a></li>
            <li><a href="mesBillets.php" class="hover:text-emerald-400 transition">Mes billets</a></li>
            <li><a href="profil.php" class="hover:text-emerald-400 transition">Profil</a></li>
        </ul>

        <button onclick="logout()"
                class="px-5 py-2.5 bg-rose-600 rounded-xl hover:bg-rose-700 transition font-semibold shadow-lg">
            Déconnexion
        </button>
    </div>
</nav>

<!-- ================= HERO ================= -->
<header class="relative overflow-hidden py-16">
    <div class="absolute inset-0 bg-gradient-to-br from-slate-950 via-slate-900 to-slate-950"></div>
    <div class="absolute top-0 right-0 w-96 h-96 bg-emerald-500/10 blur-3xl rounded-full"></div>
    <div class="absolute bottom-0 left-0 w-96 h-96 bg-cyan-500/10 blur-3xl rounded-full"></div>

    <div class="relative max-w-7xl mx-auto px-4">
        <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-8">
            <div>
                <h1 class="text-5xl md:text-6xl font-extrabold tracking-tight">
                    Matchs disponibles
                </h1>
                <p class="text-slate-300 text-lg mt-3">
                    Recherchez, filtrez et réservez vos billets en toute simplicité.
                </p>
            </div>

            <div class="flex gap-4">
                <div class="bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-center">
                    <p class="text-sm text-slate-400">Total matchs</p>
                    <p class="text-3xl font-bold text-emerald-400"><?= count($matchs) ?></p>
                </div>
                <div class="bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-center">
                    <p class="text-sm text-slate-400">Statut achat</p>
                    <p class="text-3xl font-bold text-emerald-400">Ouvert</p>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- ================= MAIN CONTENT ================= -->
<main class="max-w-7xl mx-auto px-4 py-12">
    <!-- ===== FILTER BAR ===== -->
    <div class="bg-white/5 border border-white/10 rounded-3xl p-6 md:p-8 backdrop-blur shadow-2xl">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
            <div class="lg:col-span-2">
                <label class="block text-sm text-slate-300 mb-2">Recherche (équipes / stade)</label>
                <input id="q" type="text" placeholder="Ex: Raja, Wydad, Mohammed V..."
                       class="w-full bg-slate-900/60 border border-white/10 rounded-2xl px-5 py-4 text-lg
                              focus:ring-4 focus:ring-emerald-500/30 focus:border-emerald-500/50 outline-none transition">
            </div>

            <div>
                <label class="block text-sm text-slate-300 mb-2">Date min</label>
                <input id="dateFrom" type="date"
                       class="w-full bg-slate-900/60 border border-white/10 rounded-2xl px-5 py-4
                              focus:ring-4 focus:ring-emerald-500/30 focus:border-emerald-500/50 outline-none transition">
            </div>

            <div>
                <label class="block text-sm text-slate-300 mb-2">Date max</label>
                <input id="dateTo" type="date"
                       class="w-full bg-slate-900/60 border border-white/10 rounded-2xl px-5 py-4
                              focus:ring-4 focus:ring-emerald-500/30 focus:border-emerald-500/50 outline-none transition">
            </div>

            <div>
                <label class="block text-sm text-slate-300 mb-2">Trier par</label>
                <select id="sort"
                        class="w-full bg-slate-900/60 border border-white/10 rounded-2xl px-5 py-4
                               focus:ring-4 focus:ring-emerald-500/30 focus:border-emerald-500/50 outline-none transition">
                    <option value="dateAsc">Date (croissante)</option>
                    <option value="dateDesc">Date (décroissante)</option>
                    <option value="durationAsc">Durée (croissante)</option>
                    <option value="durationDesc">Durée (décroissante)</option>
                </select>
            </div>

            <div class="flex items-end">
                <button id="reset"
                        class="w-full px-6 py-4 rounded-2xl bg-white/10 hover:bg-white/15 border border-white/10
                               transition font-semibold text-lg">
                    Réinitialiser
                </button>
            </div>
        </div>

        <div class="mt-6 flex justify-between items-center">
            <p class="text-slate-400">
                Résultats : <span id="countVisible" class="font-bold text-emerald-400">0</span>
                / <span class="font-bold"><?= count($matchs) ?></span>
            </p>
            <p id="noResults" class="hidden text-amber-300 font-semibold">
                Aucun match ne correspond à vos critères.
            </p>
        </div>
    </div>

    <!-- ===== MATCH LIST (style mesBillets) ===== -->
    <div id="matchList" class="mt-12 space-y-6">
        <?php if (empty($matchs)): ?>
            <div class="text-center py-24 bg-white/5 border border-white/10 rounded-3xl">
                <p class="text-2xl font-bold text-slate-300">Aucun match disponible pour le moment</p>
                <p class="text-slate-500 mt-3">Revenez plus tard ✨</p>
            </div>
        <?php endif; ?>

        <?php foreach ($matchs as $m): ?>
            <?php
                $dateIso = '';
                if (!empty($m->date_match)) {
                    $ts = strtotime($m->date_match);
                    if ($ts !== false) $dateIso = date('Y-m-d', $ts);
                }

                $team1 = $m->equipe1->nom ?? '';
                $team2 = $m->equipe2->nom ?? '';
                $stade = $m->stade ?? '';
                $duration = (int)($m->duree ?? 0);
            ?>

            <article class="match-card group bg-white/5 border border-white/10 rounded-2xl p-6 shadow-xl
                            hover:shadow-2xl hover:border-emerald-500/40 hover:bg-white/8 transition-all duration-300"
                     data-team1="<?= htmlspecialchars(mb_strtolower($team1)) ?>"
                     data-team2="<?= htmlspecialchars(mb_strtolower($team2)) ?>"
                     data-stadium="<?= htmlspecialchars(mb_strtolower($stade)) ?>"
                     data-date="<?= htmlspecialchars($dateIso) ?>"
                     data-duration="<?= $duration ?>">

                <!-- Ligne principale : équipes + VS + bouton -->
                <div class="flex items-center justify-between gap-6">
                    <div class="flex items-center gap-6 flex-1">
                        <!-- Équipe 1 -->
                        <div class="flex items-center gap-4">
                            <div class="w-16 h-16 rounded-xl bg-white/10 border border-white/10 overflow-hidden flex-shrink-0">
                                <img src="<?= htmlspecialchars($m->equipe1->logo) ?>"
                                     alt="<?= htmlspecialchars($team1) ?>"
                                     class="w-full h-full object-contain p-2">
                            </div>
                            <div>
                                <p class="font-extrabold text-xl"><?= htmlspecialchars($team1) ?></p>
                            </div>
                        </div>

                        <!-- VS -->
                        <div class="flex items-center">
                            <span class="px-5 py-2 rounded-full bg-emerald-500/20 text-emerald-400 font-black text-lg border border-emerald-500/30">
                                VS
                            </span>
                        </div>

                        <!-- Équipe 2 -->
                        <div class="flex items-center gap-4">
                            <div>
                                <p class="font-extrabold text-xl text-right"><?= htmlspecialchars($team2) ?></p>
                            </div>
                            <div class="w-16 h-16 rounded-xl bg-white/10 border border-white/10 overflow-hidden flex-shrink-0">
                                <img src="<?= htmlspecialchars($m->equipe2->logo) ?>"
                                     alt="<?= htmlspecialchars($team2) ?>"
                                     class="w-full h-full object-contain p-2">
                            </div>
                        </div>
                    </div>

                    <!-- Bouton d'achat -->
                    <div class="flex-shrink-0">
                        <a href="acheterBillet.php?id=<?= $m->id_match ?>"
                           class="inline-flex items-center gap-2 px-7 py-4 rounded-xl bg-emerald-500 text-slate-950
                                  font-extrabold hover:bg-emerald-400 transition shadow-lg shadow-emerald-500/30">
                            <span class="text-xl">🎟</span>
                            Acheter
                        </a>
                    </div>
                </div>

                <!-- Détails en bas -->
                <div class="mt-6 pt-6 border-t border-white/10 grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
                    <div>
                        <p class="text-sm text-slate-400">📅 Date</p>
                        <p class="font-bold text-lg mt-1"><?= htmlspecialchars($m->date_match) ?></p>
                    </div>
                    <div>
                        <p class="text-sm text-slate-400">🕐 Heure</p>
                        <p class="font-bold text-lg mt-1"><?= htmlspecialchars($m->heure) ?></p>
                    </div>
                    <div>
                        <p class="text-sm text-slate-400">⏱ Durée</p>
                        <p class="font-bold text-lg mt-1"><?= (int)$m->duree ?> min</p>
                    </div>
                    <div>
                        <p class="text-sm text-slate-400">🏟 Stade</p>
                        <p class="font-bold text-lg mt-1"><?= htmlspecialchars($m->stade ?? '—') ?></p>
                    </div>
                </div>

                <!-- Effet hover subtil -->
                <div class="absolute inset-0 rounded-2xl bg-gradient-to-r from-emerald-500/5 to-cyan-500/5 opacity-0 group-hover:opacity-100 transition pointer-events-none"></div>
            </article>
        <?php endforeach; ?>
    </div>
</main>

<!-- ================= FOOTER ================= -->
<footer class="mt-20 border-t border-white/10 py-10">
    <div class="max-w-7xl mx-auto px-4 text-center text-slate-500">
        &copy; 2025 BuyMatch – Réservation de billets sportifs
    </div>
</footer>

<script>
function logout() {
    if (confirm("Voulez-vous vraiment vous déconnecter ?")) {
        window.location.href = "../logout.php";
    }
}

(function () {
    const q = document.getElementById('q');
    const dateFrom = document.getElementById('dateFrom');
    const dateTo = document.getElementById('dateTo');
    const sort = document.getElementById('sort');
    const reset = document.getElementById('reset');
    const cards = Array.from(document.querySelectorAll('.match-card'));
    const countVisible = document.getElementById('countVisible');
    const noResults = document.getElementById('noResults');
    const list = document.getElementById('matchList');

    const normalize = (s) => (s || '')
        .toString()
        .toLowerCase()
        .normalize('NFD')
        .replace(/[\u0300-\u036f]/g, '')
        .trim();

    function apply() {
        const query = normalize(q.value);
        const min = dateFrom.value || null;
        const max = dateTo.value || null;

        let visibleCards = cards.filter(card => {
            const t1 = normalize(card.dataset.team1);
            const t2 = normalize(card.dataset.team2);
            const st = normalize(card.dataset.stadium);
            const d  = card.dataset.date || '';

            const textOk = !query || (t1.includes(query) || t2.includes(query) || st.includes(query));
            const minOk = !min || (d && d >= min);
            const maxOk = !max || (d && d <= max);

            const ok = textOk && minOk && maxOk;
            card.classList.toggle('hidden', !ok);
            return ok;
        });

        const mode = sort.value;
        visibleCards.sort((a, b) => {
            const da = a.dataset.date || '';
            const db = b.dataset.date || '';
            const dura = parseInt(a.dataset.duration || '0', 10);
            const durb = parseInt(b.dataset.duration || '0', 10);

            if (mode === 'dateAsc')  return da.localeCompare(db);
            if (mode === 'dateDesc') return db.localeCompare(da);
            if (mode === 'durationAsc')  return dura - durb;
            if (mode === 'durationDesc') return durb - dura;
            return 0;
        });

        visibleCards.forEach(card => list.appendChild(card));

        countVisible.textContent = String(visibleCards.length);
        noResults.classList.toggle('hidden', visibleCards.length !== 0);
    }

    function resetAll() {
        q.value = '';
        dateFrom.value = '';
        dateTo.value = '';
        sort.value = 'dateAsc';
        apply();
    }

    ['input', 'change'].forEach(evt => {
        q.addEventListener(evt, apply);
        dateFrom.addEventListener(evt, apply);
        dateTo.addEventListener(evt, apply);
        sort.addEventListener(evt, apply);
    });
    reset.addEventListener('click', resetAll);

    apply();
})();
</script>

</body>
</html>