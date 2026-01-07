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
</head>

<body class="bg-slate-950 text-slate-100">

<!-- ================= NAVBAR ================= -->
<nav class="sticky top-0 z-50 bg-slate-950/90 backdrop-blur border-b border-white/10 shadow-lg">
    <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
        <div class="flex items-center gap-2 text-2xl font-extrabold tracking-tight">
            <span class="text-2xl">🎫</span>
            <span>BuyMatch</span>
        </div>

        <ul class="hidden md:flex gap-8 font-semibold text-slate-200">
            <li><a href="dashboard.php" class="hover:text-emerald-400 transition">Dashboard</a></li>
            <li><a href="matchs.php" class="text-emerald-400">Matchs</a></li>
            <li><a href="mesBillets.php" class="hover:text-emerald-400 transition">Mes billets</a></li>
            <li><a href="profil.php" class="hover:text-emerald-400 transition">Profil</a></li>
        </ul>

        <button onclick="logout()"
                class="px-4 py-2 bg-rose-600 rounded-lg hover:bg-rose-700 transition font-semibold">
            Déconnexion
        </button>
    </div>
</nav>

<!-- ================= HERO ================= -->
<header class="relative overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-r from-slate-950 via-slate-900 to-slate-950"></div>
    <div class="absolute -top-24 -right-24 w-72 h-72 bg-emerald-500/20 blur-3xl rounded-full"></div>
    <div class="absolute -bottom-24 -left-24 w-72 h-72 bg-cyan-500/20 blur-3xl rounded-full"></div>

    <div class="relative max-w-7xl mx-auto px-4 py-14">
        <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-6">
            <div>
                <h1 class="text-4xl md:text-5xl font-extrabold tracking-tight mb-2">
                    Matchs disponibles
                </h1>
                <p class="text-slate-300">
                    Recherchez un match, filtrez, triez et réservez vos billets.
                </p>
            </div>

            <div class="flex gap-3">
                <div class="bg-white/5 border border-white/10 rounded-2xl px-5 py-3">
                    <p class="text-xs text-slate-400">Total</p>
                    <p class="text-2xl font-bold">
                        <?= count($matchs) ?>
                    </p>
                </div>
                <div class="bg-white/5 border border-white/10 rounded-2xl px-5 py-3">
                    <p class="text-xs text-slate-400">Achat</p>
                    <p class="text-2xl font-bold text-emerald-400">Ouvert</p>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- ================= CONTENT ================= -->
<main class="bg-slate-950">
    <section class="py-10">
        <div class="max-w-7xl mx-auto px-4">

            <!-- ===== SEARCH / FILTER BAR (client-side) ===== -->
            <div class="bg-white/5 border border-white/10 rounded-2xl p-5 md:p-6 shadow-xl">
                <div class="flex flex-col lg:flex-row lg:items-end gap-4">
                    <div class="flex-1">
                        <label class="block text-sm text-slate-300 mb-2">Recherche (équipes / stade)</label>
                        <input id="q" type="text" placeholder="Ex: Raja, Wydad, Stade Mohammed V..."
                               class="w-full bg-slate-900/60 border border-white/10 rounded-xl px-4 py-3
                                      outline-none focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-500/40">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm text-slate-300 mb-2">Date min</label>
                            <input id="dateFrom" type="date"
                                   class="w-full bg-slate-900/60 border border-white/10 rounded-xl px-4 py-3
                                          outline-none focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-500/40">
                        </div>
                        <div>
                            <label class="block text-sm text-slate-300 mb-2">Date max</label>
                            <input id="dateTo" type="date"
                                   class="w-full bg-slate-900/60 border border-white/10 rounded-xl px-4 py-3
                                          outline-none focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-500/40">
                        </div>
                    </div>

                    <div class="w-full lg:w-64">
                        <label class="block text-sm text-slate-300 mb-2">Trier</label>
                        <select id="sort"
                                class="w-full bg-slate-900/60 border border-white/10 rounded-xl px-4 py-3
                                       outline-none focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-500/40">
                            <option value="dateAsc">Date (croissante)</option>
                            <option value="dateDesc">Date (décroissante)</option>
                            <option value="durationAsc">Durée (croissante)</option>
                            <option value="durationDesc">Durée (décroissante)</option>
                        </select>
                    </div>

                    <div class="flex gap-3">
                        <button id="reset"
                                class="px-5 py-3 rounded-xl bg-white/10 hover:bg-white/15 border border-white/10 transition font-semibold">
                            Réinitialiser
                        </button>
                    </div>
                </div>

                <div class="mt-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                    <p class="text-sm text-slate-400">
                        Résultats : <span id="countVisible" class="font-bold text-slate-200">0</span>
                        / <span class="font-bold text-slate-200"><?= count($matchs) ?></span>
                    </p>
                    <p id="noResults" class="hidden text-sm text-amber-300 font-semibold">
                        Aucun match ne correspond à votre recherche.
                    </p>
                </div>
            </div>

            <!-- ===== LIST ===== -->
            <div class="mt-8 space-y-6" id="matchList">

                <?php if (empty($matchs)): ?>
                    <div class="text-center py-20 bg-white/5 border border-white/10 rounded-2xl">
                        <p class="text-slate-300 font-semibold text-lg">Aucun match disponible pour le moment</p>
                        <p class="text-slate-500 mt-2">Revenez plus tard ✨</p>
                    </div>
                <?php endif; ?>

                <?php foreach ($matchs as $m): ?>
                    <?php
                        // Pour que le filtre date marche bien côté JS
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

                    <article
                        class="match-card group bg-white/5 border border-white/10 rounded-2xl p-6 md:p-8 shadow-xl
                               hover:shadow-2xl hover:border-emerald-500/30 transition"
                        data-team1="<?= htmlspecialchars(mb_strtolower($team1)) ?>"
                        data-team2="<?= htmlspecialchars(mb_strtolower($team2)) ?>"
                        data-stadium="<?= htmlspecialchars(mb_strtolower($stade)) ?>"
                        data-date="<?= htmlspecialchars($dateIso) ?>"
                        data-duration="<?= $duration ?>"
                    >

                        <!-- TOP ROW -->
                        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                            <!-- Teams -->
                            <div class="flex flex-col md:flex-row md:items-center gap-6">
                                <div class="flex items-center gap-4">
                                    <div class="w-14 h-14 rounded-2xl bg-white/10 border border-white/10 flex items-center justify-center overflow-hidden">
                                        <img src="<?= htmlspecialchars($m->equipe1->logo) ?>"
                                             alt="logo equipe 1"
                                             class="w-12 h-12 object-contain">
                                    </div>
                                    <div>
                                        <p class="text-xs text-slate-400">Équipe 1</p>
                                        <p class="font-extrabold text-lg md:text-xl">
                                            <?= htmlspecialchars($team1) ?>
                                        </p>
                                    </div>
                                </div>

                                <div class="flex items-center gap-3 justify-center">
                                    <span class="px-3 py-1 rounded-full bg-white/10 border border-white/10 text-slate-200 font-bold">
                                        VS
                                    </span>
                                </div>

                                <div class="flex items-center gap-4">
                                    <div class="w-14 h-14 rounded-2xl bg-white/10 border border-white/10 flex items-center justify-center overflow-hidden">
                                        <img src="<?= htmlspecialchars($m->equipe2->logo) ?>"
                                             alt="logo equipe 2"
                                             class="w-12 h-12 object-contain">
                                    </div>
                                    <div>
                                        <p class="text-xs text-slate-400">Équipe 2</p>
                                        <p class="font-extrabold text-lg md:text-xl">
                                            <?= htmlspecialchars($team2) ?>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- CTA -->
                            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                                <a href="acheterBillet.php?id=<?= $m->id_match ?>"
                                   class="inline-flex items-center justify-center gap-2 px-7 py-3 rounded-xl
                                          bg-emerald-500 text-slate-950 font-extrabold
                                          hover:bg-emerald-400 transition shadow-lg shadow-emerald-500/20">
                                    <span>🎟</span>
                                    Acheter un billet
                                </a>
                            </div>
                        </div>

                        <!-- DETAILS -->
                        <div class="mt-6 grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div class="bg-slate-900/50 border border-white/10 rounded-xl p-4">
                                <p class="text-sm text-slate-400">📅 Date</p>
                                <p class="font-bold text-lg"><?= htmlspecialchars($m->date_match) ?></p>
                                <?php if (!empty($dateIso)): ?>
                                    <p class="text-xs text-slate-500 mt-1">ISO: <?= htmlspecialchars($dateIso) ?></p>
                                <?php endif; ?>
                            </div>

                            <div class="bg-slate-900/50 border border-white/10 rounded-xl p-4">
                                <p class="text-sm text-slate-400">🕐 Heure</p>
                                <p class="font-bold text-lg"><?= htmlspecialchars($m->heure) ?></p>
                            </div>

                            <div class="bg-slate-900/50 border border-white/10 rounded-xl p-4">
                                <p class="text-sm text-slate-400">⏱ Durée</p>
                                <p class="font-bold text-lg"><?= (int)$m->duree ?> min</p>
                            </div>

                            <div class="bg-slate-900/50 border border-white/10 rounded-xl p-4">
                                <p class="text-sm text-slate-400">🏟 Stade</p>
                                <p class="font-bold text-lg"><?= htmlspecialchars($m->stade ?? '—') ?></p>
                            </div>
                        </div>

                        <!-- subtle bottom glow -->
                        <div class="mt-6 h-px bg-gradient-to-r from-transparent via-emerald-500/30 to-transparent opacity-0 group-hover:opacity-100 transition"></div>
                    </article>
                <?php endforeach; ?>
            </div>

        </div>
    </section>

    <!-- ================= FOOTER ================= -->
    <footer class="mt-10 bg-slate-950 border-t border-white/10">
        <div class="max-w-7xl mx-auto px-4 py-10 text-center text-slate-500">
            &copy; 2025 BuyMatch – Réservation de billets sportifs
        </div>
    </footer>
</main>

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
        .replace(/[\u0300-\u036f]/g, '') // remove accents
        .trim();

    function apply() {
        const query = normalize(q.value);
        const min = dateFrom.value || null;
        const max = dateTo.value || null;

        // Filter
        let visibleCards = cards.filter(card => {
            const t1 = normalize(card.dataset.team1);
            const t2 = normalize(card.dataset.team2);
            const st = normalize(card.dataset.stadium);
            const d  = card.dataset.date || ''; // ISO expected: YYYY-MM-DD (if possible)

            const textOk = !query || (t1.includes(query) || t2.includes(query) || st.includes(query));
            const minOk = !min || (d && d >= min);
            const maxOk = !max || (d && d <= max);

            const ok = textOk && minOk && maxOk;
            card.classList.toggle('hidden', !ok);
            return ok;
        });

        // Sort only the visible ones
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

        // Re-append in sorted order (only visible cards)
        visibleCards.forEach(card => list.appendChild(card));

        // Count + empty state
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

    // init
    apply();
})();
</script>

</body>
</html>
