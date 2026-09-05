<?php

session_start();

require("../../BaseDonnee/connect.php");
require("../../BaseDonnee/csrf.php");

$bdd = new PDO(
    "mysql:host=$host;dbname=$dbname;charset=utf8",
    $login,
    $password,
    [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]
);

/*
 * Vérification de la connexion
 */
if (!isset($_SESSION['id']) || empty($_SESSION['id'])) {
    header('Location: reception.php');
    exit;
}

$id_utilisateur = (int) $_SESSION['id'];

/*
 * Vérification de la requête POST + CSRF
 */
if (
    $_SERVER['REQUEST_METHOD'] !== 'POST' ||
    !isset($_POST['id']) ||
    !ctype_digit($_POST['id']) ||
    !isset($_POST['action']) ||
    !in_array($_POST['action'], ['me', 'everyone'], true) ||
    !isset($_POST['csrf_token']) ||
    !verifierCSRF($_POST['csrf_token'])
) {
    header('Location: reception.php');
    exit;
}

$id_message = (int) $_POST['id'];
$action = $_POST['action'];

/*
 * Récupération du message
 */
$requete = $bdd->prepare(
    'SELECT
        id_expediteur,
        id_destinataire
     FROM messages
     WHERE id_message = ?'
);

$requete->execute([$id_message]);

$message = $requete->fetch();

/*
 * Le message n'existe pas
 */
if (!$message) {
    header('Location: reception.php');
    exit;
}

$id_expediteur = (int) $message['id_expediteur'];
$id_destinataire = (int) $message['id_destinataire'];

/*
 * Déterminer avec qui je suis en conversation
 */
$id_correspondant = ($id_expediteur === $id_utilisateur)
    ? $id_destinataire
    : $id_expediteur;

/*
 * SUPPRIMER POUR MOI
 */
if ($action === 'me') {

    /*
     * Je suis l'expéditeur
     */
    if ($id_expediteur === $id_utilisateur) {

        $suppression = $bdd->prepare(
            'UPDATE messages
             SET supprime_par_expediteur = 1
             WHERE id_message = ?'
        );

        $suppression->execute([$id_message]);
    }

    /*
     * Je suis le destinataire
     */
    elseif ($id_destinataire === $id_utilisateur) {

        $suppression = $bdd->prepare(
            'UPDATE messages
             SET supprime_par_destinataire = 1
             WHERE id_message = ?'
        );

        $suppression->execute([$id_message]);
    }
}


/*
 * SUPPRIMER POUR TOUT LE MONDE
 */
elseif ($action === 'everyone') {

    /*
     * Seul l'expéditeur peut supprimer
     * le message pour tout le monde.
     */
    if ($id_expediteur === $id_utilisateur) {

        $suppression = $bdd->prepare(
            'UPDATE messages
             SET
                supprime_par_expediteur = 1,
                supprime_par_destinataire = 1
             WHERE id_message = ?'
        );

        $suppression->execute([$id_message]);
    }
}

/*
 * Retour à la conversation
 */
header(
    'Location: lectureMessageControleur.php?id=' . $id_correspondant
);

exit;
