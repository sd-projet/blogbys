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
    header('Location: connexionControleur.php');
    exit;
}

$id_utilisateur = (int) $_SESSION['id'];


/*
 * Récupération des informations de l'utilisateur
 */

$requeteUtilisateur = $bdd->prepare(
    "SELECT id, pseudo, mail
     FROM membres
     WHERE id = ?"
);

$requeteUtilisateur->execute([$id_utilisateur]);

$utilisateur = $requeteUtilisateur->fetch();

if (!$utilisateur) {
    session_destroy();
    header('Location: connexionControleur.php');
    exit;
}


/*
 * Informations utilisateur
 */

$pseudo = $utilisateur['pseudo'];
$mail = $utilisateur['mail'];


/*
 * Nombre de publications
 */

$requetePublications = $bdd->prepare(
    "SELECT COUNT(*) AS nombre_publications
     FROM publications
     WHERE id_memb = ?"
);

$requetePublications->execute([$id_utilisateur]);

$nombrePublications = (int) $requetePublications->fetch()['nombre_publications'];


/*
 * Nombre de likes reçus
 */

$requeteLikes = $bdd->prepare(
    "SELECT COUNT(*) AS nombre_likes
     FROM likes
     INNER JOIN publications
        ON likes.id_publication = publications.id_photo
     WHERE publications.id_memb = ?"
);

$requeteLikes->execute([$id_utilisateur]);

$nombreLikes = (int) $requeteLikes->fetch()['nombre_likes'];


/*
 * Nombre de commentaires reçus
 */

$requeteCommentaires = $bdd->prepare(
    "SELECT COUNT(*) AS nombre_commentaires
     FROM commentaires
     INNER JOIN publications
        ON commentaires.id_publication = publications.id_photo
     WHERE publications.id_memb = ?"
);

$requeteCommentaires->execute([$id_utilisateur]);

$nombreCommentaires = (int) $requeteCommentaires->fetch()['nombre_commentaires'];


/*
 * Affichage de la vue
 */

require("../../Vue/compte/profil.php");