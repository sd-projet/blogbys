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

/*
 * Vérification de la connexion
 */
if (!isset($_SESSION['id']) || empty($_SESSION['id'])) {
    header('Location: ../compte/connexionControleur.php');
    exit;
}

$id_utilisateur = (int) $_SESSION['id'];

/*
 * Message d'erreur éventuel
 */
$erreur = null;

if (isset($_GET['erreur'])) {

    if ($_GET['erreur'] === 'destinataire') {
        $erreur = "❌ Ce pseudo n'existe pas.";
    }
}

/*
 * Nombre de messages non lus
 */
$requeteNonLus = $bdd->prepare(
    'SELECT COUNT(*) AS nombre
     FROM messages
     WHERE id_destinataire = ?
     AND lu = 0
     AND supprime_par_destinataire = 0'
);

$requeteNonLus->execute([
    $id_utilisateur
]);

$nombreNonLus = (int) $requeteNonLus->fetch()['nombre'];

/*
 * Récupération des conversations
 *
 * On récupère, pour chaque correspondant,
 * le dernier message encore visible par l'utilisateur connecté.
 *
 * Un message est visible :
 *
 * - si je suis l'expéditeur :
 *   supprime_par_expediteur = 0
 *
 * - si je suis le destinataire :
 *   supprime_par_destinataire = 0
 */
$requete = $bdd->prepare(
    'SELECT
        m.id_message,
        m.id_expediteur,
        m.id_destinataire,
        m.message,
        m.lu,

        CASE
            WHEN m.id_expediteur = :utilisateur1
            THEN m.id_destinataire
            ELSE m.id_expediteur
        END AS id_correspondant,

        membres.pseudo AS pseudo_correspondant

     FROM messages m

     INNER JOIN membres
        ON membres.id = CASE
            WHEN m.id_expediteur = :utilisateur2
            THEN m.id_destinataire
            ELSE m.id_expediteur
        END

     WHERE

        /*
         * Le message doit être visible pour moi
         */
        (
            (
                m.id_expediteur = :utilisateur3
                AND m.supprime_par_expediteur = 0
            )
            OR
            (
                m.id_destinataire = :utilisateur4
                AND m.supprime_par_destinataire = 0
            )
        )

        /*
         * Il ne doit pas exister de message plus récent
         * et visible dans la même conversation.
         */
        AND NOT EXISTS (

            SELECT 1
            FROM messages m2

            WHERE

                /*
                 * Même conversation
                 */
                (
                    (
                        m2.id_expediteur = :utilisateur5
                        AND m2.id_destinataire =
                            CASE
                                WHEN m.id_expediteur = :utilisateur6
                                THEN m.id_destinataire
                                ELSE m.id_expediteur
                            END
                    )

                    OR

                    (
                        m2.id_destinataire = :utilisateur7
                        AND m2.id_expediteur =
                            CASE
                                WHEN m.id_expediteur = :utilisateur8
                                THEN m.id_destinataire
                                ELSE m.id_expediteur
                            END
                    )
                )

                /*
                 * Message plus récent
                 */
                AND m2.id_message > m.id_message

                /*
                 * Message plus récent visible pour moi
                 */
                AND
                (
                    (
                        m2.id_expediteur = :utilisateur9
                        AND m2.supprime_par_expediteur = 0
                    )
                    OR
                    (
                        m2.id_destinataire = :utilisateur10
                        AND m2.supprime_par_destinataire = 0
                    )
                )
        )

     ORDER BY m.id_message DESC'
);

$requete->execute([
    'utilisateur1' => $id_utilisateur,
    'utilisateur2' => $id_utilisateur,
    'utilisateur3' => $id_utilisateur,
    'utilisateur4' => $id_utilisateur,
    'utilisateur5' => $id_utilisateur,
    'utilisateur6' => $id_utilisateur,
    'utilisateur7' => $id_utilisateur,
    'utilisateur8' => $id_utilisateur,
    'utilisateur9' => $id_utilisateur,
    'utilisateur10' => $id_utilisateur
]);

$messages = $requete->fetchAll();

/*
 * Affichage de la vue
 */
require("../../Vue/messages/messages.php");