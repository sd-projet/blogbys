<?php

session_start();

require("../../BaseDonnee/connect.php");
require("../../BaseDonnee/csrf.php");
require("../../BaseDonnee/cloudinary.php");

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
    'SELECT id_photo, miniature_public_id
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

if (!empty($publication['miniature_public_id'])) {

    try {

        $cloudinary
            ->uploadApi()
            ->destroy(
                $publication['miniature_public_id'],
                [
                    'resource_type' => 'image',
                ]
            );

    } catch (\Throwable $e) {
        // La publication est déjà supprimée.
        // On ne bloque pas la redirection.
    }
}

/*
 * Suppression de l'ancienne image locale
 * si elle existe encore.
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