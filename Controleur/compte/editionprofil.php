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
    header("Location: connexionControleur.php");
    exit;
}

$id_utilisateur = (int) $_SESSION['id'];

$messageErreur = null;
$messageConfirmation = null;

/*
 * Récupération des informations actuelles
 */
$requser = $bdd->prepare(
    "SELECT id, pseudo, mail
     FROM membres
     WHERE id = ?"
);

$requser->execute([$id_utilisateur]);

$user = $requser->fetch();

if (!$user) {
    session_destroy();
    header("Location: connexionControleur.php");
    exit;
}

/*
 * Modification du profil
 */
if (isset($_POST['modifierprofil'])) {

    $newpseudo = trim($_POST['newpseudo'] ?? '');
    $newmail = trim($_POST['newmail'] ?? '');
    $newmdp1 = $_POST['newmdp1'] ?? '';
    $newmdp2 = $_POST['newmdp2'] ?? '';

    /*
     * Vérification du pseudo
     */
    if ($newpseudo === '') {

        $messageErreur = "Le pseudo ne peut pas être vide.";

    } elseif (mb_strlen($newpseudo) > 255) {

        $messageErreur = "Votre pseudo ne doit pas dépasser 255 caractères.";

    }

    /*
     * Vérification du mail
     */
    elseif ($newmail === '') {

        $messageErreur = "L'adresse mail ne peut pas être vide.";

    } elseif (!filter_var($newmail, FILTER_VALIDATE_EMAIL)) {

        $messageErreur = "Votre adresse mail n'est pas valide.";

    }

    /*
     * Vérification de l'unicité du pseudo
     */
    if ($messageErreur === null && $newpseudo !== $user['pseudo']) {

        $reqpseudo = $bdd->prepare(
            "SELECT id
             FROM membres
             WHERE pseudo = ?
             AND id != ?"
        );

        $reqpseudo->execute([
            $newpseudo,
            $id_utilisateur
        ]);

        if ($reqpseudo->fetch()) {
            $messageErreur = "Ce pseudo est déjà utilisé.";
        }
    }

    /*
     * Vérification de l'unicité du mail
     */
    if ($messageErreur === null && $newmail !== $user['mail']) {

        $reqmail = $bdd->prepare(
            "SELECT id
             FROM membres
             WHERE mail = ?
             AND id != ?"
        );

        $reqmail->execute([
            $newmail,
            $id_utilisateur
        ]);

        if ($reqmail->fetch()) {
            $messageErreur = "Cette adresse mail est déjà utilisée.";
        }
    }

    /*
     * Vérification du nouveau mot de passe
     */
    if (
        $messageErreur === null &&
        ($newmdp1 !== '' || $newmdp2 !== '')
    ) {

        if (strlen($newmdp1) < 8) {

            $messageErreur = "Votre nouveau mot de passe doit contenir au moins 8 caractères.";

        } elseif ($newmdp1 !== $newmdp2) {

            $messageErreur = "Vos deux mots de passe ne correspondent pas.";
        }
    }

    /*
     * Mise à jour
     */
    if ($messageErreur === null) {

        /*
         * Mise à jour du pseudo et du mail
         */
        $update = $bdd->prepare(
            "UPDATE membres
             SET pseudo = ?, mail = ?
             WHERE id = ?"
        );

        $update->execute([
            $newpseudo,
            $newmail,
            $id_utilisateur
        ]);

        /*
         * Mise à jour du mot de passe
         * uniquement si un nouveau mot de passe a été renseigné.
         */
        if ($newmdp1 !== '') {

            $motdepasseHash = password_hash(
                $newmdp1,
                PASSWORD_DEFAULT
            );

            $updateMdp = $bdd->prepare(
                "UPDATE membres
                 SET motdepasse = ?
                 WHERE id = ?"
            );

            $updateMdp->execute([
                $motdepasseHash,
                $id_utilisateur
            ]);
        }

        /*
         * Mise à jour de la session
         */
        $_SESSION['pseudo'] = $newpseudo;
        $_SESSION['mail'] = $newmail;

        /*
         * Redirection pour éviter
         * la soumission multiple du formulaire.
         */
        header("Location: editionprofil.php?modification=ok");
        exit;
    }
}

/*
 * Message de confirmation après redirection
 */
if (
    isset($_GET['modification']) &&
    $_GET['modification'] === 'ok'
) {
    $messageConfirmation = "Votre profil a été mis à jour avec succès.";
}

/*
 * Données affichées dans la vue
 */
$pseudo = $user['pseudo'];
$mail = $user['mail'];

?>

<?php require("../../Vue/compte/editionProfil.php"); ?>

