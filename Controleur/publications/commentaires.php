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
 * Vérification de l'ID de la publication
 */
if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
    header('Location: ../../Controleur/accueil.php');
    exit;
}

$id_publication = (int) $_GET['id'];
$id_utilisateur = isset($_SESSION['id'])
    ? (int) $_SESSION['id']
    : 0;

/*
 * Récupération de la publication
 */
$requetePublication = $bdd->prepare(
    "SELECT publications.*, membres.pseudo
     FROM publications
     INNER JOIN membres ON publications.id_memb = membres.id
     WHERE publications.id_photo = ?"
);

$requetePublication->execute([$id_publication]);

$publication = $requetePublication->fetch();

if (!$publication) {
    header('Location: ../../Controleur/accueil.php');
    exit;
}

/*
 * Ajout d'un commentaire
 * Seulement pour les utilisateurs connectés
 */
if (
    isset($_SESSION['id']) &&
    !empty($_SESSION['id']) &&
    $_SERVER['REQUEST_METHOD'] === 'POST'
) {

    $commentaire = trim($_POST['commentaire'] ?? '');

    if ($commentaire === '') {

        $_SESSION['message_commentaire'] = [
            'type' => 'error',
            'texte' => 'Votre commentaire ne peut pas être vide.'
        ];

    } elseif (mb_strlen($commentaire) > 1000) {

        $_SESSION['message_commentaire'] = [
            'type' => 'error',
            'texte' => 'Votre commentaire ne peut pas dépasser 1000 caractères.'
        ];

    } else {

        $requeteCommentaire = $bdd->prepare(
            "INSERT INTO commentaires
                (id_memb, pseudo, commentaire, id_publication)
            VALUES (?, ?, ?, ?)"
        );

        $requeteCommentaire->execute([
            $id_utilisateur,
            $_SESSION['pseudo'],
            $commentaire,
            $id_publication
        ]);

        $_SESSION['message_commentaire'] = [
            'type' => 'success',
            'texte' => 'Votre commentaire a bien été publié.'
        ];
    }

    /*
     * Redirection après l'envoi
     */
    header(
        'Location: commentaires.php?id=' . $id_publication
    );

    exit;
}

/*
 * Récupération des commentaires
 * Accessible aux utilisateurs connectés et non connectés
 */

$requeteCommentaires = $bdd->prepare(
    "SELECT id_comm, id_memb, pseudo, commentaire, id_publication
     FROM commentaires
     WHERE id_publication = ?
     ORDER BY id_comm DESC"
);

$requeteCommentaires->execute([$id_publication]);

$commentaires = $requeteCommentaires->fetchAll();

/*
 * Message après ajout d'un commentaire
 */
$messageCommentaire = $_SESSION['message_commentaire'] ?? null;

unset($_SESSION['message_commentaire']);

/*
 * Affichage de la vue
 */
require("../../Vue/publications/commentairesVueProfil.php");