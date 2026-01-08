<?php
session_start();
require_once "../../config/Database.php";
require_once "../../classes/Achteur.php";
$acheteur = Achteur::getAcheteurConnected();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../../mesBillets.php?error=invalid_request');
    exit;
}
$id_match = isset($_POST['id_match']) ? (int)$_POST['id_match'] : 0;
$note     = isset($_POST['note']) ? (int)$_POST['note'] : 0;
$contenu  = isset($_POST['contenu']) ? trim($_POST['contenu']) : '';
$match = MatchSport::getMatchById($id_match);

if ($id_match <= 0) {
    header('Location: ../../mesBillets.php?error=invalid_match');
    exit;
}

if ($note < 1 || $note > 5) {
    header('Location: ../../mesBillets.php?error=invalid_rating');
    exit;
}

if (strlen($contenu) < 10) {
    header('Location: ../../pages/achteur/mesBillets.php?error=comment_too_short');
    exit;
}


$hasTicket = $acheteur->getBillet($id_match);

if (!$hasTicket) {
    header('Location: ../../pages/achteur/mesBillets.php?error=no_ticket_for_match');
    exit;
}

$matchDateTime = $match->date_match." ".$match->heure;
$now = date('Y-m-d H:i:s');

if ($matchDateTime > $now) {
    header('Location: ../../mesBillets.php?error=match_not_passed');
    exit;
}

$alreadyCommented = $acheteur->dejaCommenter($id_match);

if ($alreadyCommented) {
    header('Location: ../../mesBillets.php?error=already_commented');
    exit;
}
try {
    $stmt = $acheteur->db->prepare("
        INSERT INTO commentaire 
        (id_acheteur, id_match, contenu, note, date_commentaire)
        VALUES (?, ?, ?, ?, NOW())
    ");

    $success = $stmt->execute([
        $acheteur->id,
        $id_match,
        $contenu,
        $note
    ]);

    if ($success) {
        header('Location: ../../mesBillets.php?success=comment_added');
    } else {
        header('Location: ../../mesBillets.php?error=insert_failed');
    }
} catch (Exception $e) {
    error_log("Erreur ajout commentaire : " . $e->getMessage());
    header('Location: ../../mesBillets.php?error=server_error');
}

exit;