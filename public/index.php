<?php
session_start();
require_once "../config/Database.php";
require_once "../classes/MatchSport.php";
require_once "../classes/Equipe.php";
require_once "../classes/Statistique.php";
require_once "../classes/Category.php";
require_once "../classes/Commentaire.php";

$acheteur = null;
if (isset($_SESSION['user_id'])) {
    require_once "../../classes/Achteur.php";
    $acheteur = Achteur::getAcheteurConnected();
}

$matchs = MatchSport::getAvailableMatchs(); // Utilisation de la méthode statique
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BuyMatch - Réservez vos billets sportifs</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white text-gray-900">
    <!-- Navigation -->
    <nav class="sticky top-0 z-50 bg-gray-900 text-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
            <div class="flex items-center gap-2 text-2xl font-bold">
                <span>⚽</span>
                <span>BuyMatch</span>
            </div>
            <ul class="hidden md:flex gap-8">
                <li><a href="#hero" class="nav-link active hover:text-green-500 transition">Accueil</a></li>
                <li><a href="#matches" class="nav-link hover:text-green-500 transition">Matchs</a></li>
                <li><a href="#about" class="nav-link hover:text-green-500 transition">À propos</a></li>
                <li><a href="#blog" class="nav-link hover:text-green-500 transition">Blog</a></li>
                <li><a href="#contact" class="nav-link hover:text-green-500 transition">Contact</a></li>
            </ul>
            <div class="flex gap-3">
                <button class="px-4 py-2 border border-white rounded hover:bg-white hover:text-gray-900 transition" onclick="showLoginModal()">Connexion</button>
                <button class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition" onclick="showRegisterModal()">Inscription</button>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="hero" class="min-h-screen bg-gradient-to-r from-gray-900 to-gray-800 text-white flex items-center justify-center px-4">
        <div class="text-center">
            <h1 class="text-5xl md:text-6xl font-bold mb-4">Réservez vos billets<br>pour les plus grands matchs</h1>
            <p class="text-xl text-gray-300 mb-8">Accédez aux meilleurs événements sportifs en quelques clics</p>
            <button class="px-8 py-3 bg-green-600 text-white rounded-lg text-lg hover:bg-green-700 transition" onclick="scrollToSection('#matches')">Découvrir les matchs</button>
        </div>
    </section>

    <!-- Search Section -->
    <section id="search-section" class="bg-gray-50 py-8">
        <div class="max-w-7xl mx-auto px-4">
            <h2 class="text-2xl font-bold text-center mb-6">Trouvez votre match</h2>
            <div class="flex gap-2">
                <input type="text" id="searchInput" class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-green-600" placeholder="Rechercher par équipe, ville ou date...">
                <button class="px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition" onclick="searchMatches()">🔍 Rechercher</button>
            </div>
        </div>
    </section>

    <!-- Matches Grid -->
    <section id="matches" class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4">
            <h2 class="text-4xl font-bold mb-12 text-center">Matchs à venir</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="matchesGrid">
                <?php if (empty($matchs)): ?>
                    <p class="col-span-full text-center text-gray-600 text-xl py-10">Aucun match disponible pour le moment</p>
                <?php else: ?>
                    <?php foreach ($matchs as $match): ?>
                    <article 
                        class="match-card group bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl hover:shadow-emerald-500/20 transition-all duration-500 border border-gray-100"
                        data-team1="<?= strtolower(htmlspecialchars($match->equipe1->nom)) ?>"
                        data-team2="<?= strtolower(htmlspecialchars($match->equipe2->nom)) ?>"
                    >
                        <!-- Header avec équipes -->
                        <div class="bg-gradient-to-r from-slate-900 to-emerald-900 text-white p-6">
                            <div class="flex items-center justify-between mb-6">
                                <div class="text-center flex-1">
                                    <img src="<?= htmlspecialchars($match->equipe1->logo ?? 'https://via.placeholder.com/80') ?>"
                                         alt="<?= htmlspecialchars($match->equipe1->nom) ?>"
                                         class="w-20 h-20 mx-auto rounded-full object-contain bg-white/10 p-2 shadow-lg">
                                    <p class="mt-3 font-extrabold text-lg"><?= htmlspecialchars($match->equipe1->nom) ?></p>
                                </div>
                                <div class="text-3xl font-black text-emerald-400 px-4">VS</div>
                                <div class="text-center flex-1">
                                    <img src="<?= htmlspecialchars($match->equipe2->logo ?? 'https://via.placeholder.com/80') ?>"
                                         alt="<?= htmlspecialchars($match->equipe2->nom) ?>"
                                         class="w-20 h-20 mx-auto rounded-full object-contain bg-white/10 p-2 shadow-lg">
                                    <p class="mt-3 font-extrabold text-lg"><?= htmlspecialchars($match->equipe2->nom) ?></p>
                                </div>
                            </div>

                            <div class="grid grid-cols-3 gap-3 text-center text-sm">
                                <div class="bg-white/10 rounded-lg py-2">
                                    <p class="text-emerald-300">Date</p>
                                    <p class="font-bold"><?= date('d/m/Y', strtotime($match->date_match)) ?></p>
                                </div>
                                <div class="bg-white/10 rounded-lg py-2">
                                    <p class="text-emerald-300">Heure</p>
                                    <p class="font-bold"><?= substr($match->heure, 0, 5) ?></p>
                                </div>
                                <div class="bg-white/10 rounded-lg py-2">
                                    <p class="text-emerald-300">Stade</p>
                                    <p class="font-bold text-xs"><?= htmlspecialchars($match->stade) ?></p>
                                </div>
                            </div>
                        </div>

                        <!-- Catégories de billets -->
                        <div class="p-6 space-y-4">
                            <h3 class="font-bold text-lg text-gray-800">Catégories disponibles</h3>
                            <?php if (empty($match->categories)): ?>
                                <p class="text-gray-500 text-center py-4">Catégories bientôt disponibles</p>
                            <?php else: ?>
                                <div class="space-y-3">
                                    <?php foreach ($match->categories as $cat): ?>
                                        <div class="flex justify-between items-center bg-gray-50 rounded-xl px-4 py-3">
                                            <div>
                                                <p class="font-semibold"><?= htmlspecialchars($cat->nom) ?></p>
                                                <p class="text-sm text-gray-600"><?= $cat->nb_place ?> places</p>
                                            </div>
                                            <p class="text-xl font-bold text-emerald-600"><?= number_format($cat->prix, 0) ?> MAD</p>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>

                            <!-- Bouton Réserver -->
                            <div class="flex gap-3 mt-6">
                                <?php if ($acheteur): ?>
                                    <a href="acheterBillet.php?id=<?= $match->id_match ?>"
                                       class="flex-1 text-center py-3 bg-emerald-600 text-white rounded-xl font-bold hover:bg-emerald-700 transition shadow-lg">
                                        Réserver
                                    </a>
                                <?php else: ?>
                                    <button onclick="showLoginModal()" 
                                            class="flex-1 text-center py-3 bg-emerald-600 text-white rounded-xl font-bold hover:bg-emerald-700 transition shadow-lg">
                                        Réserver
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </article>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- About Us Section -->
    <section id="about" class="py-20 bg-gradient-to-b from-gray-50 to-white">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-5xl font-bold mb-4">À Propos de BuyMatch</h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">Votre plateforme de confiance pour accéder aux meilleurs événements sportifs du monde</p>
            </div>
            
            <div class="grid md:grid-cols-2 gap-12 items-center mb-16">
                <div class="space-y-6">
                    <h3 class="text-3xl font-bold text-gray-900">Qui sommes-nous ?</h3>
                    <p class="text-lg text-gray-700 leading-relaxed">BuyMatch est la plateforme leader de réservation de billets pour les événements sportifs. Depuis 2020, nous facilitons l'accès aux meilleurs matchs de football, rugby, basket-ball et bien d'autres sports à travers le monde.</p>
                    <p class="text-lg text-gray-700 leading-relaxed">Notre mission est simple : rendre la réservation de billets sportifs facile, sécurisée et accessible à tous. Avec plus de 500 000 clients satisfaits, nous sommes fiers d'être votre partenaire de confiance pour vivre les plus grands moments du sport.</p>
                    <button class="px-8 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-semibold">En savoir plus</button>
                </div>
                
                <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-2xl p-12 text-center text-white shadow-2xl">
                    <div class="text-8xl mb-4">🏟️</div>
                    <h4 class="text-2xl font-bold">L'expérience sportive<br>réinventée</h4>
                </div>
            </div>

            <!-- Stats Section -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white border-l-4 border-green-600 rounded-lg p-8 shadow-lg hover:shadow-xl transition">
                    <div class="text-4xl font-bold text-green-600 mb-2">500K+</div>
                    <p class="text-gray-600 text-lg">Clients satisfaits</p>
                    <p class="text-sm text-gray-500 mt-2">Rejoignez notre communauté</p>
                </div>
                <div class="bg-white border-l-4 border-green-600 rounded-lg p-8 shadow-lg hover:shadow-xl transition">
                    <div class="text-4xl font-bold text-green-600 mb-2">1000+</div>
                    <p class="text-gray-600 text-lg">Événements par an</p>
                    <p class="text-sm text-gray-500 mt-2">Football, rugby, basketball</p>
                </div>
                <div class="bg-white border-l-4 border-green-600 rounded-lg p-8 shadow-lg hover:shadow-xl transition">
                    <div class="text-4xl font-bold text-green-600 mb-2">50+</div>
                    <p class="text-gray-600 text-lg">Pays couverts</p>
                    <p class="text-sm text-gray-500 mt-2">Partout dans le monde</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Blog Section -->
    <section id="blog" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-5xl font-bold mb-4">Derniers articles</h2>
                <p class="text-xl text-gray-600">Découvrez les tendances et actualités du monde du sport</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Article 1 -->
                <div class="group bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-100">
                    <div class="h-48 bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center text-6xl group-hover:scale-110 transition-transform duration-300">📈</div>
                    <div class="p-8">
                        <span class="inline-block px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm font-semibold mb-3">Tendances</span>
                        <h3 class="text-2xl font-bold mb-3 group-hover:text-green-600 transition">Les tendances du marché des billets en 2025</h3>
                        <p class="text-gray-600 mb-6 leading-relaxed">Découvrez comment le marché des billets sportifs évolue et quelles sont les nouvelles tendances qui émergent. Les technologies blockchain révolutionnent le secteur...</p>
                        <a href="#" class="inline-flex items-center text-green-600 font-semibold hover:text-green-700 transition group/link">Lire l'article <span class="ml-2 group-hover/link:translate-x-2 transition">→</span></a>
                    </div>
                </div>

                <!-- Article 2 -->
                <div class="group bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-100">
                    <div class="h-48 bg-gradient-to-br from-purple-500 to-purple-600 flex items-center justify-center text-6xl group-hover:scale-110 transition-transform duration-300">🎤</div>
                    <div class="p-8">
                        <span class="inline-block px-3 py-1 bg-purple-100 text-purple-700 rounded-full text-sm font-semibold mb-3">Interview</span>
                        <h3 class="text-2xl font-bold mb-3 group-hover:text-green-600 transition">Interview : Vivre l'expérience VIP</h3>
                        <p class="text-gray-600 mb-6 leading-relaxed">Nous avons parlé avec des fans qui ont profité de notre offre VIP premium. Leurs expériences inoubliables et les moments magiques au stade...</p>
                        <a href="#" class="inline-flex items-center text-green-600 font-semibold hover:text-green-700 transition group/link">Lire l'article <span class="ml-2 group-hover/link:translate-x-2 transition">→</span></a>
                    </div>
                </div>

                <!-- Article 3 -->
                <div class="group bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-100">
                    <div class="h-48 bg-gradient-to-br from-yellow-500 to-yellow-600 flex items-center justify-center text-6xl group-hover:scale-110 transition-transform duration-300">🏆</div>
                    <div class="p-8">
                        <span class="inline-block px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-sm font-semibold mb-3">Histoire</span>
                        <h3 class="text-2xl font-bold mb-3 group-hover:text-green-600 transition">Les meilleurs matchs de l'histoire</h3>
                        <p class="text-gray-600 mb-6 leading-relaxed">Revivez les moments inoubliables du sport mondial. Des finales épiques aux remontées spectaculaires, découvrez les rencontres marquantes...</p>
                        <a href="#" class="inline-flex items-center text-green-600 font-semibold hover:text-green-700 transition group/link">Lire l'article <span class="ml-2 group-hover/link:translate-x-2 transition">→</span></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-20 bg-gradient-to-b from-gray-50 to-white">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-5xl font-bold mb-4">Nous Contacter</h2>
                <p class="text-xl text-gray-600">Nous sommes là pour vous aider et répondre à vos questions</p>
            </div>
            
            <div class="grid md:grid-cols-2 gap-12">
                <!-- Form -->
                <div class="bg-white rounded-2xl shadow-xl p-10 border border-gray-100">
                    <h3 class="text-2xl font-bold mb-8">Envoyez-nous un message</h3>
                    <form id="contactForm" class="space-y-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Votre nom</label>
                            <input type="text" placeholder="Jean Dupont" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-green-600 focus:ring-2 focus:ring-green-100 transition" required>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Votre email</label>
                            <input type="email" placeholder="jean@example.com" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-green-600 focus:ring-2 focus:ring-green-100 transition" required>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Sujet</label>
                            <input type="text" placeholder="Comment pouvons-nous vous aider ?" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-green-600 focus:ring-2 focus:ring-green-100 transition" required>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Votre message</label>
                            <textarea placeholder="Écrivez votre message..." rows="5" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-green-600 focus:ring-2 focus:ring-green-100 transition resize-none" required></textarea>
                        </div>
                        <button type="submit" class="w-full px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-semibold text-lg">Envoyer le message</button>
                    </form>
                </div>

                <!-- Contact Info -->
                <div class="space-y-8">
                    <div class="bg-white rounded-2xl shadow-lg p-8 border-l-4 border-green-600 hover:shadow-xl transition">
                        <div class="flex items-start gap-4">
                            <div class="text-3xl">📧</div>
                            <div>
                                <h4 class="text-xl font-bold mb-2">Email</h4>
                                <p class="text-gray-600">contact@buymatch.com</p>
                                <p class="text-sm text-gray-500 mt-1">Réponse en 24h</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl shadow-lg p-8 border-l-4 border-green-600 hover:shadow-xl transition">
                        <div class="flex items-start gap-4">
                            <div class="text-3xl">📞</div>
                            <div>
                                <h4 class="text-xl font-bold mb-2">Téléphone</h4>
                                <p class="text-gray-600">+33 1 23 45 67 89</p>
                                <p class="text-sm text-gray-500 mt-1">Lun-Ven: 9h-18h</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl shadow-lg p-8 border-l-4 border-green-600 hover:shadow-xl transition">
                        <div class="flex items-start gap-4">
                            <div class="text-3xl">📍</div>
                            <div>
                                <h4 class="text-xl font-bold mb-2">Adresse</h4>
                                <p class="text-gray-600">123 Avenue des Champs-Élysées</p>
                                <p class="text-gray-600">75008 Paris, France</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl shadow-lg p-8 border-l-4 border-green-600 hover:shadow-xl transition">
                        <div class="flex items-start gap-4">
                            <div class="text-3xl">🕐</div>
                            <div>
                                <h4 class="text-xl font-bold mb-2">Horaires</h4>
                                <p class="text-gray-600">Lun-Ven: 9h - 18h</p>
                                <p class="text-gray-600">Sam: 10h - 16h</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-16">
        <div class="max-w-7xl mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-10 mb-12">
                <div>
                    <div class="flex items-center gap-2 text-2xl font-bold mb-6">
                        <span>⚽</span>
                        <span>BuyMatch</span>
                    </div>
                    <p class="text-gray-400 text-sm leading-relaxed">Votre plateforme de confiance pour réserver les meilleurs billets sportifs du monde.</p>
                </div>
                
                <div>
                    <h4 class="text-lg font-bold mb-6 text-white border-b border-green-600 pb-2">À Propos</h4>
                    <ul class="space-y-3">
                        <li><a href="#about" class="text-gray-400 hover:text-green-500 transition">Notre histoire</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-green-500 transition">Équipe</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-green-500 transition">Carrières</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-green-500 transition">Presse</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="text-lg font-bold mb-6 text-white border-b border-green-600 pb-2">Aide</h4>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-gray-400 hover:text-green-500 transition">FAQ</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-green-500 transition">Support</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-green-500 transition">Conditions</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-green-500 transition">Confidentialité</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="text-lg font-bold mb-6 text-white border-b border-green-600 pb-2">Réseaux</h4>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-gray-400 hover:text-green-500 transition">Facebook</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-green-500 transition">Twitter</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-green-500 transition">Instagram</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-green-500 transition">LinkedIn</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-gray-700 pt-8 text-center">
                <p class="text-gray-400">&copy; 2025 BuyMatch. Tous droits réservés.</p>
            </div>
        </div>
    </footer>

    <!-- Login Modal - Premium Design -->
    <div id="loginModal" class="hidden fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md relative overflow-hidden">
            <!-- Header Gradient -->
            <div class="bg-gradient-to-r from-green-600 to-green-700 px-8 py-8 text-white">
                <h2 class="text-3xl font-bold">Connexion</h2>
                <p class="text-green-100 mt-2">Accédez à votre compte BuyMatch</p>
            </div>
            
            <button onclick="closeLoginModal()" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 text-2xl z-10">×</button>
            
            <form id="loginForm" class="p-8 space-y-5" action="../auth/signIn.php" method="post">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                    <input type="email" name="email" placeholder="votre@email.com" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-green-600 focus:ring-2 focus:ring-green-100 transition" required>
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Mot de passe</label>
                    <input type="password" name="password" placeholder="••••••••" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-green-600 focus:ring-2 focus:ring-green-100 transition" required>
                </div>
                
                <div class="flex items-center justify-between text-sm">
                    <label class="flex items-center">
                        <input type="checkbox" class="mr-2">
                        <span class="text-gray-700">Se souvenir de moi</span>
                    </label>
                    <a href="#" class="text-green-600 hover:text-green-700 font-semibold">Mot de passe oublié ?</a>
                </div>
                
                <button type="submit" class="w-full px-6 py-3 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-lg hover:from-green-700 hover:to-green-800 transition font-semibold text-lg mt-6">Se connecter</button>
            </form>
            
            <div class="px-8 pb-8 text-center text-gray-600">
                <p>Pas encore inscrit ? <button onclick="switchToRegister()" class="text-green-600 hover:text-green-700 font-semibold">Créer un compte</button></p>
            </div>
        </div>
    </div>

    <!-- Register Modal - Premium Design with Role Selection -->
    <div id="registerModal" class="hidden fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center z-50 p-4 overflow-y-auto">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md relative overflow-hidden my-8">
            <!-- Header Gradient -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-8 py-8 text-white">
                <h2 class="text-3xl font-bold">Créer un compte</h2>
                <p class="text-blue-100 mt-2">Rejoignez la communauté BuyMatch</p>
            </div>
            
            <button onclick="closeRegisterModal()" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 text-2xl z-10 bg-white rounded-full w-8 h-8 flex items-center justify-center">×</button>
            
            <form id="registerForm" class="p-8 space-y-4 max-h-96 overflow-y-auto" method="post" action="../auth/signUp.php">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Prénom</label>
                        <input type="text" name="nom" placeholder="Jean" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-100 transition" required>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nom</label>
                        <input type="text" name="prenom" placeholder="Dupont" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-100 transition" required>
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                    <input type="email" name="email" placeholder="votre@email.com" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-100 transition" required>
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Téléphone</label>
                    <input type="tel" name="phone" placeholder="+33 6 12 34 56 78" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-100 transition" required>
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Mot de passe</label>
                    <input type="password" name="pass" placeholder="••••••••" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-100 transition" required>
                </div>
                
                <!-- Role Selection with Enhanced Design -->
                <fieldset class="border-2 border-gray-200 rounded-xl p-4 mt-6">
                    <legend class="font-bold text-lg text-gray-900 px-2">Sélectionnez votre rôle</legend>
                    <div class="space-y-3 mt-4">
                        <!-- Acheteur Option -->
                        <label class="flex items-start p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-blue-500 hover:bg-blue-50 transition">
                            <input type="radio" name="role" value="ACHETEUR" class="mt-1 mr-4 w-5 h-5 cursor-pointer" required>
                            <div class="flex-1">
                                <div class="font-bold text-gray-900 text-lg">🎫 Acheteur</div>
                                <div class="text-sm text-gray-600 mt-1">Achetez des billets pour vos événements favoris</div>
                            </div>
                        </label>
                        
                        <!-- Organisateur Option -->
                        <label class="flex items-start p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-blue-500 hover:bg-blue-50 transition">
                            <input type="radio" name="role" value="ORGANISATEUR" class="mt-1 mr-4 w-5 h-5 cursor-pointer" required>
                            <div class="flex-1">
                                <div class="font-bold text-gray-900 text-lg">📊 Organisateur</div>
                                <div class="text-sm text-gray-600 mt-1">Créez et gérez vos événements sportifs</div>
                            </div>
                        </label>
                    </div>
                </fieldset>
                
                <button type="submit" class="w-full px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg hover:from-blue-700 hover:to-blue-800 transition font-semibold text-lg mt-6">S'inscrire</button>
            </form>
            
            <div class="px-8 pb-8 text-center text-gray-600 bg-gray-50">
                <p>Déjà inscrit ? <button onclick="switchToLogin()" class="text-blue-600 hover:text-blue-700 font-semibold">Se connecter</button></p>
            </div>
        </div>
    </div>

    <script src="js/main.js"></script>
    <script src="js/auth.js"></script>
    <script>
        // Fonctions modals (inchangées)
        function showLoginModal() { document.getElementById("loginModal").classList.remove("hidden") }
        function closeLoginModal() { document.getElementById("loginModal").classList.add("hidden") }
        function showRegisterModal() { document.getElementById("registerModal").classList.remove("hidden") }
        function closeRegisterModal() { document.getElementById("registerModal").classList.add("hidden") }
        function switchToRegister() { closeLoginModal(); showRegisterModal(); }
        function switchToLogin() { closeRegisterModal(); showLoginModal(); }

        window.onclick = (event) => {
            const loginModal = document.getElementById("loginModal")
            const registerModal = document.getElementById("registerModal")
            if (event.target === loginModal) loginModal.classList.add("hidden")
            if (event.target === registerModal) registerModal.classList.add("hidden")
        }

        // === RECHERCHE PAR NOM D'ÉQUIPE (en temps réel) ===
        const searchInput = document.getElementById('searchInput');
        const matchCards = document.querySelectorAll('.match-card');
        const matchesGrid = document.getElementById('matchesGrid');

        // Fonction de normalisation (supprime accents et passe en minuscule)
        function normalize(str) {
            return str
                .normalize('NFD')
                .replace(/[\u0300-\u036f]/g, '')
                .toLowerCase();
        }

        // Filtrage
        function filterMatches() {
            const query = normalize(searchInput.value.trim());

            let visibleCount = 0;

            matchCards.forEach(card => {
                const team1 = normalize(card.dataset.team1);
                const team2 = normalize(card.dataset.team2);

                const matchesQuery = !query || team1.includes(query) || team2.includes(query);

                card.classList.toggle('hidden', !matchesQuery);

                if (matchesQuery) visibleCount++;
            });

            // Message si aucun résultat
            if (visibleCount === 0 && query) {
                if (!document.getElementById('noResultsMsg')) {
                    const msg = document.createElement('p');
                    msg.id = 'noResultsMsg';
                    msg.className = 'col-span-full text-center text-gray-600 text-xl py-10';
                    msg.textContent = 'Aucun match trouvé pour votre recherche.';
                    matchesGrid.appendChild(msg);
                }
            } else {
                const msg = document.getElementById('noResultsMsg');
                if (msg) msg.remove();
            }
        }

        // Écoute les frappes dans la barre de recherche
        searchInput.addEventListener('input', filterMatches);

        // Optionnel : bouton de recherche (clic)
        document.querySelector('#search-section button').addEventListener('click', filterMatches);

        // Scroll smooth
        function scrollToSection(section) {
            document.querySelector(section).scrollIntoView({ behavior: 'smooth' });
        }
    </script>
</body>
</html>
