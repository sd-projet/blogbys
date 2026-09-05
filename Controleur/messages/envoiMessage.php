<?php

session_start();

require("../../BaseDonnee/connect.php");

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
    header('Location: ../compte/connexionControleur.php');
    exit;
}

$id_expediteur = (int) $_SESSION['id'];

/*
 * Vérification de l'envoi du formulaire
 */
if (!isset($_POST['envoi_message'])) {
    header('Location: reception.php');
    exit;
}

/*
 * Récupération des données
 */
$id_destinataire = 0;

/*
 * Depuis une conversation :
 * on reçoit directement l'ID du destinataire.
 */
if (isset($_POST['id_destinataire'])) {

    $id_destinataire = (int) $_POST['id_destinataire'];

}

/*
 * Depuis "Nouveau message" :
 * on reçoit le pseudo du destinataire.
 */
elseif (isset($_POST['destinataire'])) {

    $pseudo_destinataire = trim($_POST['destinataire']);

    if ($pseudo_destinataire === '') {
        header('Location: reception.php?erreur=destinataire');
        exit;
    }

    $requeteDestinataire = $bdd->prepare(
        'SELECT id
         FROM membres
         WHERE pseudo = ?'
    );

    $requeteDestinataire->execute([
        $pseudo_destinataire
    ]);

    $destinataire = $requeteDestinataire->fetch();

    /*
     * Le pseudo n'existe pas
     */
    if (!$destinataire) {
        header('Location: reception.php?erreur=destinataire');
        exit;
    }

    $id_destinataire = (int) $destinataire['id'];
}

$message = trim($_POST['message'] ?? '');

/* Limite messages */
if (mb_strlen($message) > 3000) {
    header('Location: reception.php');
    exit;
}
/*
 * Vérification des données
 */
if ($id_destinataire <= 0 || $message === '') {
    header('Location: reception.php');
    exit;
}

/*
 * Empêche de s'envoyer un message à soi-même
 */
if ($id_destinataire === $id_expediteur) {
    header('Location: reception.php');
    exit;
}

/*
 * Vérification que le destinataire existe
 */
$requeteDestinataire = $bdd->prepare(
    'SELECT id
     FROM membres
     WHERE id = ?'
);

$requeteDestinataire->execute([
    $id_destinataire
]);

$destinataire = $requeteDestinataire->fetch();

if (!$destinataire) {
    header('Location: reception.php');
    exit;
}

/*
 * Insertion du message
 */
$insertion = $bdd->prepare(
    'INSERT INTO messages
    (id_expediteur, id_destinataire, message)
    VALUES (?, ?, ?)'
);

$insertion->execute([
    $id_expediteur,
    $id_destinataire,
    $message
]);

/*
 * Retour vers la conversation
 *
 * Ici "id" correspond à l'utilisateur avec lequel
 * on veut ouvrir la conversation.
 */
header(
    'Location: lectureMessageControleur.php?id='
    . $id_destinataire
);

exit;
