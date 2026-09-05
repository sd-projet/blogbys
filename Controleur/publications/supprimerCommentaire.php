<?php

session_start();

require("../../BaseDonnee/connect.php");
require("../../BaseDonnee/csrf.php");

$bdd = new PDO(
    "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
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
    header('Location: ../../Controleur/connexionControleur.php');
    exit;
}

/*
 * Suppression uniquement en POST
 */
if (
    $_SERVER['REQUEST_METHOD'] !== 'POST' ||
    !isset($_POST['id_comm']) ||
    !ctype_digit($_POST['id_comm']) ||
    !isset($_POST['csrf_token']) ||
    !verifierCSRF($_POST['csrf_token'])
) {
    header('Location: ../../Controleur/accueil.php');
    exit;
}

$id_commentaire = (int) $_POST['id_comm'];
$id_utilisateur = (int) $_SESSION['id'];

/*
 * Récupération du commentaire
 * On vérifie qu'il appartient à l'utilisateur
 */
$requeteCommentaire = $bdd->prepare(
    "SELECT id_publication
     FROM commentaires
     WHERE id_comm = ?
     AND id_memb = ?"
);

$requeteCommentaire->execute([
    $id_commentaire,
    $id_utilisateur
]);

$commentaire = $requeteCommentaire->fetch();

if (!$commentaire) {
    header('Location: ../../Controleur/accueil.php');
    exit;
}

/*
 * Suppression
 */
$requeteSuppression = $bdd->prepare(
    "DELETE FROM commentaires
     WHERE id_comm = ?
     AND id_memb = ?"
);

$requeteSuppression->execute([
    $id_commentaire,
    $id_utilisateur
]);

$_SESSION['message_commentaire'] = [
    'type' => 'success',
    'texte' => 'Votre commentaire a bien été supprimé.'
];

/*
 * Retour à la publication
 */
header(
    'Location: commentaires.php?id=' .
    (int) $commentaire['id_publication']
);

exit;