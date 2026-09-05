<?php

session_start();

require("../../BaseDonnee/connect.php");

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

$id_utilisateur = (int) $_SESSION['id'];

/*
 * Récupération des publications de l'utilisateur connecté
 */
$publications = $bdd->prepare(
    "SELECT
        publications.*,
        COUNT(DISTINCT likes.id_like) AS nombre_likes,
        COUNT(DISTINCT commentaires.id_comm) AS nombre_commentaires
     FROM publications
     LEFT JOIN likes
        ON publications.id_photo = likes.id_publication
     LEFT JOIN commentaires
        ON publications.id_photo = commentaires.id_publication
     WHERE publications.id_memb = ?
     GROUP BY publications.id_photo
     ORDER BY publications.date_time_publication DESC"
);

$publications->execute([$id_utilisateur]);

/*
 * Affichage de la vue
 */
require("../../Vue/publications/publication.php");
