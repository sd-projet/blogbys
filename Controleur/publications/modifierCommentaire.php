<?php

session_start();

require("../../BaseDonnee/connect.php");

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
    header('Location: ../../Controleur/compte/connexionControleur.php');
    exit;
}

/*
 * Vérification de l'ID du commentaire
 */
if (
    !isset($_POST['id_comm']) ||
    !ctype_digit($_POST['id_comm'])
) {
    header('Location: ../../Controleur/accueil.php');
    exit;
}

$id_commentaire = (int) $_POST['id_comm'];
$id_utilisateur = (int) $_SESSION['id'];

/*
 * Récupération du commentaire
 * On vérifie directement qu'il appartient à l'utilisateur connecté
 */
$requeteCommentaire = $bdd->prepare(
    "SELECT *
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
 * Modification du commentaire
 */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nouveauCommentaire = trim(
        $_POST['commentaire'] ?? ''
    );

    if ($nouveauCommentaire === '') {

        $message = [
            'type' => 'error',
            'texte' => 'Votre commentaire ne peut pas être vide.'
        ];

    } elseif (mb_strlen($nouveauCommentaire) > 1000) {

        $message = [
            'type' => 'error',
            'texte' => 'Votre commentaire ne peut pas dépasser 1000 caractères.'
        ];

    } else {

        $requeteModification = $bdd->prepare(
            "UPDATE commentaires
             SET commentaire = ?
             WHERE id_comm = ?
             AND id_memb = ?"
        );

        $requeteModification->execute([
            $nouveauCommentaire,
            $id_commentaire,
            $id_utilisateur
        ]);

        $_SESSION['message_commentaire'] = [
            'type' => 'success',
            'texte' => 'Votre commentaire a bien été modifié.'
        ];

        header(
            'Location: commentaires.php?id=' .
            (int) $commentaire['id_publication']
        );

        exit;
    }
}

