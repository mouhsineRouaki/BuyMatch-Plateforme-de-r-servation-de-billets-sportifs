<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Billets - FootTick</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        @keyframes slideIn { from { opacity: 0; transform: translateX(-20px); } to { opacity: 1; transform: translateX(0); } }
        .animate-slide { animation: slideIn 0.5s ease-out forwards; }
        .ticket-edge {
            background-image: radial-gradient(circle at 0 50%, transparent 15px, white 16px);
            filter: drop-shadow(0 4px 6px rgba(0,0,0,0.05));
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 font-sans">

    <nav class="fixed w-full z-50 bg-white/90 backdrop-blur-md shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center gap-2">
                    <div class="bg-green-600 p-2 rounded-lg"><i class="fas fa-futbol text-white text-xl"></i></div>
                    <span class="text-2xl font-black text-green-700 tracking-tighter">FOOT<span class="text-gray-900">TICK</span></span>
                </div>
                
                <div class="hidden md:flex space-x-8 font-medium">
                    <a href="index.html" class="hover:text-green-600 transition">Accueil</a>
                    <a href="historique.html" class="text-green-600 font-bold border-b-2 border-green-600">Mes Billets</a>
                    <a href="#" class="hover:text-green-600 transition">Profil</a>
                </div>

                <div class="flex items-center gap-4">
                    <span class="text-sm font-bold text-gray-500 hidden sm:block">Bonjour, Ahmed</span>
                    <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center text-green-700 font-bold border-2 border-green-500">A</div>
                </div>
            </div>
        </div>
    </nav>

    <main class="pt-32 pb-20 max-w-5xl mx-auto px-4">
        
        <div class="mb-12">
            <h1 class="text-4xl font-black text-gray-900 mb-2 uppercase tracking-tight">Mon Historique</h1>
            <p class="text-gray-500 font-medium">Consultez vos réservations et téléchargez vos billets PDF.</p>
        </div>

        <div class="flex gap-4 mb-8 overflow-x-auto pb-2">
            <button class="bg-green-600 text-white px-6 py-2 rounded-xl font-bold whitespace-nowrap">Tous (12)</button>
            <button class="bg-white text-gray-500 px-6 py-2 rounded-xl font-bold border border-gray-200 hover:border-green-500 whitespace-nowrap transition">À venir (2)</button>
            <button class="bg-white text-gray-500 px-6 py-2 rounded-xl font-bold border border-gray-200 hover:border-green-500 whitespace-nowrap transition">Passés (10)</button>
        </div>

        <div class="space-y-6">
            
            <div class="bg-white rounded-3xl overflow-hidden flex flex-col md:flex-row shadow-lg border-l-8 border-green-500 animate-slide">
                <div class="p-8 flex-1">
                    <div class="flex items-center gap-3 mb-4">
                        <span class="bg-green-100 text-green-700 text-[10px] font-black px-3 py-1 rounded-full uppercase">Match à venir</span>
                        <span class="text-gray-400 text-xs font-bold italic">Réf: #FT-99281</span>
                    </div>
                    
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                        <div class="flex items-center gap-6">
                            <div class="text-center">
                                <img src="https://upload.wikimedia.org/wikipedia/fr/4/43/Logo_Olympique_de_Marseille.svg" class="h-12 w-12 mx-auto">
                                <p class="text-[10px] font-bold mt-1">OM</p>
                            </div>
                            <span class="text-xl font-black italic text-gray-300">VS</span>
                            <div class="text-center">
                                <img src="https://upload.wikimedia.org/wikipedia/fr/4/4a/Paris_Saint-Germain_FC.svg" class="h-12 w-12 mx-auto">
                                <p class="text-[10px] font-bold mt-1">PSG</p>
                            </div>
                        </div>

                        <div class="space-y-1">
                            <p class="text-sm font-bold"><i class="far fa-calendar-check text-green-600 mr-2"></i>15 Janvier 2024</p>
                            <p class="text-sm text-gray-500 font-medium"><i class="fas fa-couch text-green-600 mr-2"></i>Tribune Est - Place 412</p>
                        </div>

                        <div class="text-right">
                            <p class="text-2xl font-black text-gray-900">150 DH</p>
                            <p class="text-[10px] font-bold text-gray-400 uppercase">Catégorie Premium</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gray-50 border-l border-dashed border-gray-200 p-6 flex flex-row md:flex-col justify-center gap-3 md:w-48">
                    <button class="flex-1 bg-white border border-gray-200 hover:border-red-500 hover:text-red-500 text-gray-700 p-3 rounded-xl transition flex items-center justify-center gap-2 font-bold text-sm">
                        <i class="fas fa-file-pdf text-red-500"></i> PDF
                    </button>
                    <button class="flex-1 bg-green-600 hover:bg-green-700 text-white p-3 rounded-xl transition shadow-md shadow-green-100 flex items-center justify-center gap-2 font-bold text-sm">
                        <i class="fas fa-eye"></i> Détails
                    </button>
                </div>
            </div>

            <div class="bg-white rounded-3xl overflow-hidden flex flex-col md:flex-row shadow-sm border border-gray-100 opacity-70 grayscale hover:grayscale-0 hover:opacity-100 transition-all animate-slide" style="animation-delay: 0.1s;">
                <div class="p-8 flex-1">
                    <div class="flex items-center gap-3 mb-4">
                        <span class="bg-gray-100 text-gray-500 text-[10px] font-black px-3 py-1 rounded-full uppercase">Terminé</span>
                    </div>
                    
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                        <div class="flex items-center gap-4">
                             <p class="font-black uppercase text-gray-800">Real Madrid VS FC Barcelone</p>
                        </div>

                        <div class="text-right">
                            <div class="flex gap-1 text-yellow-400 text-xs mb-1">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                            </div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest italic">Note donnée</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gray-50 p-6 flex flex-row md:flex-col justify-center gap-3 md:w-48">
                    <button class="flex-1 border-2 border-gray-200 text-gray-500 p-3 rounded-xl font-bold text-xs hover:bg-gray-200 transition">
                        REVOIR L'AVIS
                    </button>
                </div>
            </div>

        </div>

        <div class="mt-16 grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-gray-100 flex items-center gap-4">
                <div class="w-12 h-12 bg-green-100 text-green-600 rounded-2xl flex items-center justify-center text-xl">
                    <i class="fas fa-wallet"></i>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Dépenses totales</p>
                    <p class="text-xl font-black italic">850 DH</p>
                </div>
            </div>
            <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-gray-100 flex items-center gap-4">
                <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center text-xl">
                    <i class="fas fa-ticket-alt"></i>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Billets achetés</p>
                    <p class="text-xl font-black italic">12 Billets</p>
                </div>
            </div>
            <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-gray-100 flex items-center gap-4">
                <div class="w-12 h-12 bg-yellow-100 text-yellow-600 rounded-2xl flex items-center justify-center text-xl">
                    <i class="fas fa-star"></i>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Note Moyenne</p>
                    <p class="text-xl font-black italic">4.9 / 5</p>
                </div>
            </div>
        </div>
    </main>

    <footer class="bg-gray-900 text-white py-12 px-4 mt-20">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center opacity-50">
             <span class="text-xl font-black text-green-500 tracking-tighter uppercase">FootTick</span>
             <p class="text-xs font-bold">© 2026 Espace Supporter Premium</p>
        </div>
    </footer>

</body>
</html>