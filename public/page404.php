<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>404 – Page introuvable | BuyMatch</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-white text-gray-900 min-h-screen flex flex-col">

<!-- ================= NAVBAR ================= -->
<nav class="bg-gray-900 text-white shadow-lg">
    <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
        <div class="flex items-center gap-2 text-2xl font-extrabold">
            🎟️ <span>BuyMatch</span>
        </div>

        <a href="/index.php"
           class="px-4 py-2 bg-green-600 rounded-lg font-semibold
                  hover:bg-green-700 transition">
            Accueil
        </a>
    </div>
</nav>

<!-- ================= CONTENT ================= -->
<main class="flex-grow flex items-center justify-center bg-gray-50">
    <div class="text-center px-6">

        <div class="text-8xl font-extrabold text-green-600 mb-4">
            404
        </div>

        <h1 class="text-3xl md:text-4xl font-bold mb-4">
            Oups… Page introuvable
        </h1>

        <p class="text-gray-600 max-w-xl mx-auto mb-8">
            La page que vous recherchez n’existe pas, a été supprimée
            ou son lien est incorrect.
        </p>

        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="/index.php"
               class="px-6 py-3 bg-green-600 text-white rounded-lg font-semibold
                      hover:bg-green-700 transition">
                Retour à l’accueil
            </a>

            <a href="javascript:history.back()"
               class="px-6 py-3 bg-gray-200 text-gray-900 rounded-lg font-semibold
                      hover:bg-gray-300 transition">
                Page précédente
            </a>
        </div>

        <!-- Illustration -->
        <div class="mt-12 opacity-80">
            <span class="text-6xl">⚽</span>
        </div>
    </div>
</main>

<!-- ================= FOOTER ================= -->
<footer class="bg-gray-900 text-white py-8 border-t-4 border-green-600">
    <div class="max-w-7xl mx-auto px-6 text-center text-gray-400">
        &copy; <?= date('Y') ?> BuyMatch – Tous droits réservés
    </div>
</footer>

</body>
</html>
