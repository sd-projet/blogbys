<?php

session_start();

require("../../BaseDonnee/connect.php");

/*$bdd = new PDO(
    "mysql:host=$host;dbname=$dbname;charset=utf8",
    $login,
    $password,
    [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]
);*/

$conversation = [];
$expediteur = null;
$message = true;
$erreur = null;

/*
 * Vérification de la connexion
 */
if (!isset($_SESSION['id']) || empty($_SESSION['id'])) {
    header('Location: ../compte/connexionControleur.php');
    exit;
}

$id_utilisateur = (int) $_SESSION['id'];

/*
 * Ici, id = ID du membre avec qui on converse
 */
if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
    $message = null;
    $erreur = "Conversation invalide.";
    require("../../Vue/messages/lectureMessageVue.php");
    exit;
}

$id_correspondant = (int) $_GET['id'];

/*
 * On ne peut pas discuter avec soi-même
 */
if ($id_correspondant === $id_utilisateur) {
    $message = null;
    $erreur = "Vous ne pouvez pas ouvrir une conversation avec vous-même.";
    require("../../Vue/messages/lectureMessageVue.php");
    exit;
}

/*
 * Récupération du correspondant
 */
$requeteCorrespondant = $bdd->prepare(
    'SELECT id, pseudo
     FROM membres
     WHERE id = ?'
);

$requeteCorrespondant->execute([
    $id_correspondant
]);

$expediteur = $requeteCorrespondant->fetch();

if (!$expediteur) {
    $message = null;
    $erreur = "Cet utilisateur n'existe pas.";
    require("../../Vue/messages/lectureMessageVue.php");
    exit;
}

/*
 * Récupération de toute la conversation
 */
/*$requeteConversation = $bdd->prepare(
    'SELECT
        messages.id_message,
        messages.id_expediteur,
        messages.id_destinataire,
        messages.message,
        messages.lu,
        membres.pseudo AS pseudo_expediteur
     FROM messages
     INNER JOIN membres
        ON messages.id_expediteur = membres.id
     WHERE
        (
            messages.id_expediteur = :utilisateur
            AND messages.id_destinataire = :correspondant
        )
        OR
        (
            messages.id_expediteur = :correspondant
            AND messages.id_destinataire = :utilisateur
        )
     ORDER BY messages.id_message ASC'
);*/

$requeteConversation = $bdd->prepare(
    'SELECT
        messages.id_message,
        messages.id_expediteur,
        messages.id_destinataire,
        messages.message,
        messages.lu,
        membres.pseudo AS pseudo_expediteur
     FROM messages
     INNER JOIN membres
        ON messages.id_expediteur = membres.id
     WHERE
        (
            messages.id_expediteur = :utilisateur
            AND messages.id_destinataire = :expediteur
            AND messages.supprime_par_expediteur = 0
        )
        OR
        (
            messages.id_expediteur = :expediteur
            AND messages.id_destinataire = :utilisateur
            AND messages.supprime_par_destinataire = 0
        )
     ORDER BY messages.id_message ASC'
);

$requeteConversation->execute([
    'utilisateur' => $id_utilisateur,
    'expediteur' => $id_correspondant
]);

$conversation = $requeteConversation->fetchAll();

/*
 * Marquer comme lus les messages reçus
 */
$lu = $bdd->prepare(
    'UPDATE messages
     SET lu = 1
     WHERE id_expediteur = ?
     AND id_destinataire = ?
     AND lu = 0
     AND supprime_par_destinataire = 0'
);

$lu->execute([
    $id_correspondant,
    $id_utilisateur
]);
/*
 * Affichage
 */
require("../../Vue/messages/lectureMessageVue.php");