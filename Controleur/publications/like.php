<?php

session_start();

require("../../BaseDonnee/connect.php");

header('Content-Type: application/json; charset=utf-8');

/*$bdd = new PDO(
    "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
    $login,
    $password,
    [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]
);*/

/*
 * Vérification de la connexion
 */
if (!isset($_SESSION['id']) || empty($_SESSION['id'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Vous devez être connecté pour aimer une publication.'
    ]);
    exit;
}

/*
 * Vérification de l'ID de la publication
 */
if (
    !isset($_POST['id_publication']) ||
    !ctype_digit($_POST['id_publication'])
) {
    echo json_encode([
        'success' => false,
        'message' => 'Publication invalide.'
    ]);
    exit;
}

$id_utilisateur = (int) $_SESSION['id'];
$id_publication = (int) $_POST['id_publication'];

/*
 * Vérification que la publication existe
 */
$requetePublication = $bdd->prepare(
    "SELECT id_photo
     FROM publications
     WHERE id_photo = ?"
);

$requetePublication->execute([$id_publication]);

if (!$requetePublication->fetch()) {
    echo json_encode([
        'success' => false,
        'message' => 'Cette publication n\'existe pas.'
    ]);
    exit;
}

/*
 * Vérification du like existant
 */
$requeteLike = $bdd->prepare(
    "SELECT id_like
     FROM likes
     WHERE id_memb = ?
     AND id_publication = ?"
);

$requeteLike->execute([
    $id_utilisateur,
    $id_publication
]);

$like = $requeteLike->fetch();

if ($like) {

    /*
     * Retirer le like
     */
    $requeteSuppression = $bdd->prepare(
        "DELETE FROM likes
         WHERE id_like = ?
         AND id_memb = ?"
    );

    $requeteSuppression->execute([
        $like['id_like'],
        $id_utilisateur
    ]);

    $aime = false;

} else {

    /*
     * Ajouter le like
     */
    $requeteAjout = $bdd->prepare(
        "INSERT INTO likes
            (id_memb, id_publication)
         VALUES (?, ?)"
    );

    $requeteAjout->execute([
        $id_utilisateur,
        $id_publication
    ]);

    $aime = true;
}

/*
 * Nouveau nombre de likes
 */
$requeteNombreLikes = $bdd->prepare(
    "SELECT COUNT(*) AS nombre_likes
     FROM likes
     WHERE id_publication = ?"
);

$requeteNombreLikes->execute([$id_publication]);

$nombreLikes = (int) $requeteNombreLikes->fetch()['nombre_likes'];

/*
 * Réponse AJAX
 */
echo json_encode([
    'success' => true,
    'aime' => $aime,
    'nombre_likes' => $nombreLikes
]);

exit;