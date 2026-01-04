<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails du Match - BuyMatch</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-950 text-gray-100">
    <!-- Navbar -->
    <nav class="bg-gray-900 border-b border-gray-800 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <a href="indexCopy.html" class="flex items-center gap-2 text-xl font-bold text-green-500">
                    <span>⚽</span>
                    <span>BuyMatch</span>
                </a>
                <div class="hidden md:flex items-center gap-6">
                    <a href="indexCopy.html#hero" class="text-sm text-gray-400 hover:text-white transition">Accueil</a>
                    <a href="indexCopy.html#matches" class="text-sm text-gray-400 hover:text-white transition">Matchs</a>
                    <a href="indexCopy.html#about" class="text-sm text-gray-400 hover:text-white transition">À propos</a>
                </div>
                <div class="flex items-center gap-3">
                    <button class="px-4 py-2 text-sm text-gray-400 hover:text-white transition">Connexion</button>
                    <button class="px-4 py-2 text-sm bg-green-600 hover:bg-green-700 text-white rounded-lg transition">Inscription</button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section with Teams -->
    <section class="bg-gradient-to-b from-gray-900 to-gray-950 border-b border-gray-800 py-12">
        <div class="max-w-6xl mx-auto px-4">
            <div class="text-center mb-8">
                <p class="text-gray-400 text-sm mb-2">MATCH DE FOOTBALL</p>
                <h1 id="matchTitle" class="text-4xl md:text-5xl font-bold text-white mb-4">--</h1>
                <p id="matchDate" class="text-gray-400">--</p>
            </div>

            <!-- Teams Display -->
            <div class="grid grid-cols-3 gap-8 items-center mb-12">
                <div id="team1" class="text-center">
                    <div class="text-6xl mb-4">⚽</div>
                    <h2 class="text-2xl font-bold text-white mb-2">--</h2>
                    <p class="text-gray-400">Équipe 1</p>
                </div>
                <div class="text-center">
                    <div class="text-5xl font-bold text-green-500 mb-2">VS</div>
                    <p class="text-gray-400">@</p>
                </div>
                <div id="team2" class="text-center">
                    <div class="text-6xl mb-4">⚽</div>
                    <h2 class="text-2xl font-bold text-white mb-2">--</h2>
                    <p class="text-gray-400">Équipe 2</p>
                </div>
            </div>

            <!-- Match Info Grid -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-gray-800 rounded-lg p-4 border border-gray-700">
                    <p class="text-gray-400 text-sm mb-1">Heure de démarrage</p>
                    <p id="matchTime" class="text-lg font-semibold text-white">--</p>
                </div>
                <div class="bg-gray-800 rounded-lg p-4 border border-gray-700">
                    <p class="text-gray-400 text-sm mb-1">Lieu</p>
                    <p id="matchPlace" class="text-lg font-semibold text-white">--</p>
                </div>
                <div class="bg-gray-800 rounded-lg p-4 border border-gray-700">
                    <p class="text-gray-400 text-sm mb-1">Durée</p>
                    <p id="matchDuration" class="text-lg font-semibold text-white">--</p>
                </div>
                <div class="bg-gray-800 rounded-lg p-4 border border-gray-700">
                    <p class="text-gray-400 text-sm mb-1">Capacité</p>
                    <p id="matchCapacity" class="text-lg font-semibold text-white">--</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-16 px-4">
        <div class="max-w-6xl mx-auto">
            <div class="space-y-8">
                <!-- Left Column: Tickets -->
                <div>
                    <!-- Ticket Categories -->
                    <div class="bg-gray-900 rounded-xl border border-gray-800 p-8 mb-8">
                        <h2 class="text-2xl font-bold text-white mb-6 flex items-center gap-2">
                            <span>🎫</span>
                            Sélectionner vos places
                        </h2>
                        <div class="space-y-4">
                            <!-- VIP Category -->
                            <div class="bg-gray-800 border-2 border-yellow-600 rounded-lg p-6 hover:border-yellow-500 transition">
                                <div class="flex justify-between items-start mb-4">
                                    <div>
                                        <h3 class="text-white font-bold text-lg">VIP</h3>
                                        <p class="text-yellow-400 text-sm">Places premium avec vue privilégiée</p>
                                    </div>
                                    <span class="text-2xl font-bold text-yellow-500">150€</span>
                                </div>
                                <div class="flex items-center gap-4">
                                    <p class="text-gray-400 text-sm">25 places disponibles</p>
                                    <input type="number" min="0" max="25" value="0" class="ml-auto bg-gray-700 border border-gray-600 rounded-lg px-3 py-2 text-white w-20 focus:outline-none focus:border-yellow-500 transition" placeholder="Qty" data-price="150" data-category="VIP" data-available="25">
                                </div>
                            </div>

                            <!-- Standard Category -->
                            <div class="bg-gray-800 border-2 border-blue-600 rounded-lg p-6 hover:border-blue-500 transition">
                                <div class="flex justify-between items-start mb-4">
                                    <div>
                                        <h3 class="text-white font-bold text-lg">Standard</h3>
                                        <p class="text-blue-400 text-sm">Places régulières avec bonne vue</p>
                                    </div>
                                    <span class="text-2xl font-bold text-blue-500">80€</span>
                                </div>
                                <div class="flex items-center gap-4">
                                    <p class="text-gray-400 text-sm">100 places disponibles</p>
                                    <input type="number" min="0" max="100" value="0" class="ml-auto bg-gray-700 border border-gray-600 rounded-lg px-3 py-2 text-white w-20 focus:outline-none focus:border-blue-500 transition" placeholder="Qty" data-price="80" data-category="Standard" data-available="100">
                                </div>
                            </div>

                            <!-- Other Category -->
                            <div class="bg-gray-800 border-2 border-purple-600 rounded-lg p-6 hover:border-purple-500 transition">
                                <div class="flex justify-between items-start mb-4">
                                    <div>
                                        <h3 class="text-white font-bold text-lg">Autre</h3>
                                        <p class="text-purple-400 text-sm">Places économiques</p>
                                    </div>
                                    <span class="text-2xl font-bold text-purple-500">45€</span>
                                </div>
                                <div class="flex items-center gap-4">
                                    <p class="text-gray-400 text-sm">150 places disponibles</p>
                                    <input type="number" min="0" max="150" value="0" class="ml-auto bg-gray-700 border border-gray-600 rounded-lg px-3 py-2 text-white w-20 focus:outline-none focus:border-purple-500 transition" placeholder="Qty" data-price="45" data-category="Autre" data-available="150">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Venue Info replaced with simple input -->
                    <div class="bg-gray-900 rounded-xl border border-gray-800 p-8 mb-8">
                        <h2 class="text-2xl font-bold text-white mb-6 flex items-center gap-2">
                            <span>📍</span>
                            Lieu
                        </h2>
                        <input type="text" id="venuePlace" placeholder="Lieu du match" class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-2 text-white placeholder-gray-500 focus:outline-none focus:border-green-500 transition" readonly>
                    </div>

                    <!-- Seats Availability -->
                    <div class="bg-gray-900 rounded-xl border border-gray-800 p-8 mb-8">
                        <h2 class="text-2xl font-bold text-white mb-6">État de remplissage</h2>
                        <div id="availabilityBar" class="mb-4">
                            <!-- Progress bar loaded from JS -->
                        </div>
                        <div class="flex justify-between text-sm text-gray-400">
                            <span id="soldText">--</span>
                            <span id="availableText">-- places restantes</span>
                        </div>
                    </div>

                    <!-- Booking Summary moved to same column -->
                    <div class="bg-gradient-to-b from-green-900 to-green-950 rounded-xl border border-green-700 p-8">
                        <h3 class="text-xl font-bold text-white mb-6">Résumé de commande</h3>
                        
                        <div id="bookingSummary" class="mb-6 space-y-3">
                            <div class="flex justify-between text-gray-300 text-sm pb-3 border-b border-green-700">
                                <span>Catégorie sélectionnée</span>
                                <span id="selectedCategory">Aucune</span>
                            </div>
                            <div class="flex justify-between text-gray-300 text-sm pb-3 border-b border-green-700">
                                <span>Quantité</span>
                                <span id="selectedQty">0</span>
                            </div>
                            <div class="flex justify-between text-gray-300 text-sm pb-3 border-b border-green-700">
                                <span>Prix unitaire</span>
                                <span id="unitPrice">0€</span>
                            </div>
                        </div>

                        <div class="bg-black bg-opacity-30 rounded-lg p-4 mb-6">
                            <div class="flex justify-between items-end">
                                <span class="text-gray-300">Total</span>
                                <span id="totalPrice" class="text-3xl font-bold text-green-400">0€</span>
                            </div>
                        </div>

                        <button onclick="openBookingModal()" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 rounded-lg transition mb-3">
                            Réserver maintenant
                        </button>
                        <p class="text-xs text-gray-400 text-center">Les places seront confirmées après paiement</p>
                    </div>
                </div>
            </div>

            <!-- Reviews Section -->
            <div class="mt-16">
                <h2 class="text-3xl font-bold text-white mb-8 flex items-center gap-2">
                    <span>⭐</span>
                    Avis des spectateurs
                </h2>
                <div id="reviewsContainer" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Reviews loaded from JS -->
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 border-t border-gray-800 py-12 px-4">
        <div class="max-w-6xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <div>
                    <h4 class="text-white font-bold mb-4 border-b border-green-600 pb-2">À Propos</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-green-500 transition text-sm">Notre histoire</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-green-500 transition text-sm">Équipe</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-green-500 transition text-sm">Blog</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-bold mb-4 border-b border-green-600 pb-2">Aide</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-green-500 transition text-sm">FAQ</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-green-500 transition text-sm">Support</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-green-500 transition text-sm">CGU</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-bold mb-4 border-b border-green-600 pb-2">Pour vous</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-green-500 transition text-sm">Organisateur</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-green-500 transition text-sm">API</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-green-500 transition text-sm">Partenaires</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-bold mb-4 border-b border-green-600 pb-2">Contact</h4>
                    <ul class="space-y-2">
                        <li><a href="mailto:contact@buymatch.com" class="text-gray-400 hover:text-green-500 transition text-sm">contact@buymatch.com</a></li>
                        <li><a href="tel:+33123456789" class="text-gray-400 hover:text-green-500 transition text-sm">+33 1 23 45 67 89</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 pt-8 text-center text-gray-400 text-sm">
                <p>&copy; 2025 BuyMatch. Tous droits réservés.</p>
            </div>
        </div>
    </footer>

    <!-- Booking Modal -->
    <div id="bookingModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-gray-900 border border-gray-800 rounded-xl p-8 max-w-md w-full mx-4">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-white">Confirmer votre réservation</h2>
                <button onclick="closeBookingModal()" class="text-gray-400 hover:text-white text-2xl">&times;</button>
            </div>

            <div id="modalContent" class="space-y-4 mb-6">
                <!-- Booking details will be filled here -->
            </div>

            <div class="bg-gray-800 border border-gray-700 rounded-lg p-4 mb-6">
                <div class="flex justify-between mb-2">
                    <span class="text-gray-300">Total</span>
                    <span id="modalTotalPrice" class="text-2xl font-bold text-green-400">0€</span>
                </div>
            </div>

            <button onclick="confirmBooking()" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 rounded-lg transition mb-3">
                Confirmer la réservation
            </button>
            <button onclick="closeBookingModal()" class="w-full bg-gray-800 hover:bg-gray-700 text-white font-bold py-3 rounded-lg transition">
                Annuler
            </button>
        </div>
    </div>

    <script src="js/main.js"></script>
    <script>
        // Get match ID from URL
        const params = new URLSearchParams(window.location.search);
        const matchId = parseInt(params.get('id')) || 0;
        const match = staticMatches[matchId];

        if (match) {
            // Header
            document.getElementById('matchTitle').textContent = `${match.team1} vs ${match.team2}`;
            document.getElementById('matchDate').textContent = `${match.date} • ${match.stadium}`;
            document.getElementById('team1').innerHTML = `
                <div class="text-6xl mb-4">⚽</div>
                <h2 class="text-2xl font-bold text-white mb-2">${match.team1}</h2>
                <p class="text-gray-400">Domicile</p>
            `;
            document.getElementById('team2').innerHTML = `
                <div class="text-6xl mb-4">⚽</div>
                <h2 class="text-2xl font-bold text-white mb-2">${match.team2}</h2>
                <p class="text-gray-400">Extérieur</p>
            `;

            // Match Info
            document.getElementById('matchTime').textContent = match.time;
            document.getElementById('matchPlace').textContent = match.stadium;
            document.getElementById('matchDuration').textContent = '90 minutes';
            document.getElementById('matchCapacity').textContent = match.capacity + ' places';
            document.getElementById('venuePlace').value = match.stadium;

            // Availability
            const percentFilled = Math.round((match.soldTickets / match.capacity) * 100);
            document.getElementById('availabilityBar').innerHTML = `
                <div class="w-full bg-gray-800 rounded-full h-2 overflow-hidden">
                    <div class="bg-gradient-to-r from-green-500 to-green-400 h-full" style="width: ${percentFilled}%"></div>
                </div>
            `;
            document.getElementById('soldText').textContent = match.soldTickets + ' places vendues';
            document.getElementById('availableText').textContent = (match.capacity - match.soldTickets) + ' places restantes';

            // Reviews
            const reviewsHTML = match.reviews.map(review => `
                <div class="bg-gray-800 border border-gray-700 rounded-lg p-6">
                    <div class="flex items-start gap-4 mb-4">
                        <div class="w-12 h-12 bg-green-600 rounded-full flex items-center justify-center text-white font-bold flex-shrink-0">
                            ${review.author.charAt(0)}
                        </div>
                        <div class="flex-1">
                            <h4 class="text-white font-bold">${review.author}</h4>
                            <div class="flex items-center gap-1 mt-1">
                                ${[...Array(review.rating)].map(() => '⭐').join('')}
                                <span class="text-gray-400 text-sm ml-2">${review.rating}/5</span>
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-300 text-sm leading-relaxed">${review.comment}</p>
                    <p class="text-gray-500 text-xs mt-4">${review.date}</p>
                </div>
            `).join('');
            document.getElementById('reviewsContainer').innerHTML = reviewsHTML;
        }

        function openBookingModal() {
            const inputs = document.querySelectorAll('input[data-category]');
            const bookingItems = [];
            let total = 0;

            inputs.forEach(input => {
                const qty = parseInt(input.value) || 0;
                if (qty > 0) {
                    const category = input.dataset.category;
                    const price = parseInt(input.dataset.price);
                    const subtotal = qty * price;
                    bookingItems.push({ category, qty, price, subtotal });
                    total += subtotal;
                }
            });

            if (bookingItems.length === 0) {
                alert('Veuillez sélectionner au moins une catégorie de places');
                return;
            }

            // Display in modal
            const modalContent = document.getElementById('modalContent');
            modalContent.innerHTML = bookingItems.map(item => `
                <div class="bg-gray-800 border border-gray-700 rounded-lg p-4">
                    <div class="flex justify-between mb-2">
                        <span class="text-white font-bold">${item.category}</span>
                        <span class="text-gray-400">${item.qty}x ${item.price}€</span>
                    </div>
                    <div class="flex justify-between text-green-400">
                        <span>Sous-total</span>
                        <span class="font-bold">${item.subtotal}€</span>
                    </div>
                </div>
            `).join('');

            document.getElementById('modalTotalPrice').textContent = total + '€';
            document.getElementById('bookingModal').classList.remove('hidden');
        }

        function closeBookingModal() {
            document.getElementById('bookingModal').classList.add('hidden');
        }

        function confirmBooking() {
            const total = document.getElementById('modalTotalPrice').textContent;
            alert(`Réservation confirmée!\nMontant total: ${total}\nVous recevrez un email de confirmation.`);
            closeBookingModal();
        }

        // Close modal with Escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                closeBookingModal();
            }
        });
    </script>
</body>
</html>
