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
    header('Location: ../compte/connexionControleur.php');
    exit;
}

/*
 * La suppression doit obligatoirement
 * être effectuée en POST.
 */
if (
    $_SERVER['REQUEST_METHOD'] !== 'POST' ||
    !isset($_POST['csrf_token']) ||
    !verifierCSRF($_POST['csrf_token'])
) {
    header('Location: publication.php');
    exit;
}

/*
 * Vérification de l'ID
 */
if (!isset($_POST['id']) || !ctype_digit($_POST['id'])) {
    header('Location: publication.php');
    exit;
}

$suppr_id = (int) $_POST['id'];
$id_utilisateur = (int) $_SESSION['id'];

/*
 * Vérification que la publication appartient
 * bien à l'utilisateur connecté.
 */
$requete = $bdd->prepare(
    'SELECT id_photo
     FROM publications
     WHERE id_photo = ?
     AND id_memb = ?'
);

$requete->execute([
    $suppr_id,
    $id_utilisateur
]);

$publication = $requete->fetch();

if (!$publication) {
    header('Location: publication.php');
    exit;
}

/*
 * Suppression de la publication
 */
$suppr = $bdd->prepare(
    'DELETE FROM publications
     WHERE id_photo = ?
     AND id_memb = ?'
);

$suppr->execute([
    $suppr_id,
    $id_utilisateur
]);

/*
 * Suppression de l'image associée
 */
$image = '../../miniatures/' . $suppr_id . '.jpg';

if (file_exists($image)) {
    unlink($image);
}

/*
 * Retour aux publications
 */
header('Location: publication.php');
exit;