<?php
session_start();
require_once "../classes/Achteur.php";
require_once "../classes/register.php";

$token = $_GET['token'] ?? '';
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['token'] ?? $token;
    $newPassword = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';

    if ($newPassword !== $confirmPassword) {
        $error = "Les mots de passe ne correspondent pas.";
    } elseif (strlen($newPassword) < 8) {
        $error = "Le mot de passe doit faire au moins 8 caractères.";
    } else {
        if (Register::reinitialiserMotDePasse($token, $newPassword)) {
            $success = "Votre mot de passe a été réinitialisé avec succès !";
        } else {
            $error = "Lien invalide ou expiré.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Réinitialiser mot de passe | BuyMatch</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-10 rounded-2xl shadow-2xl max-w-md w-full">
        <h1 class="text-3xl font-bold text-center mb-6">Réinitialiser votre mot de passe</h1>

        <?php if ($success): ?>
            <?php session_destroy(); ?>
            <div class="bg-green-100 text-green-700 p-4 rounded-xl mb-6 text-center">
                <?= htmlspecialchars($success) ?>
                <p class="mt-4"><a href="../public/index.php" class="text-green-600 font-bold">Se connecter</a></p>
            </div>
        <?php else: ?>
            <?php if ($error): ?>
                <div class="bg-red-100 text-red-700 p-4 rounded-xl mb-6 text-center">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <form method="POST" class="space-y-6">
                <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
                <div>
                    <label class="block text-gray-700 mb-2">Nouveau mot de passe</label>
                    <input type="password" name="password" required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-green-600">
                </div>
                <div>
                    <label class="block text-gray-700 mb-2">Confirmer le mot de passe</label>
                    <input type="password" name="confirm_password" required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-green-600">
                </div>
                <button type="submit" class="w-full bg-green-600 text-white py-3 rounded-lg font-bold hover:bg-green-700">
                    Mettre à jour
                </button>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>