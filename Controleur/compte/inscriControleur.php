<?php

require("../../tbs_3132/tbs_class.php");
require("../../BaseDonnee/connect.php");
require("../../BaseDonnee/csrf.php");

$tbs = new clsTinyButStrong;

$bdd = new PDO(
    "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
    $login,
    $password,
    [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]
);

$erreur = null;

/*
 * Vérification du formulaire d'inscription
 */
if (isset($_POST['forminscription'])) {

    if (
        !isset($_POST['csrf_token']) ||
        !verifierCSRF($_POST['csrf_token'])
    ) {
        $erreur = "Requête invalide. Veuillez réessayer.";
    } else {

        /*
        * Récupération des données
        */
        $pseudo = trim($_POST['pseudo'] ?? '');
        $mail = trim($_POST['mail'] ?? '');
        $mail2 = trim($_POST['mail2'] ?? '');
        $mdp = $_POST['mdp'] ?? '';
        $mdp2 = $_POST['mdp2'] ?? '';

        /*
        * Vérification des champs obligatoires
        */
        if (
            empty($pseudo) ||
            empty($mail) ||
            empty($mail2) ||
            empty($mdp) ||
            empty($mdp2)
        ) {

            $erreur = "Tous les champs doivent être complétés !";

        /*
        * Vérification de la longueur du pseudo
        */
        } elseif (mb_strlen($pseudo) > 255) {

            $erreur = "Votre pseudo ne doit pas dépasser 255 caractères !";

        /*
        * Vérification de la longueur du mot de passe
        */
        } elseif (strlen($mdp) < 8) {

            $erreur = "Votre mot de passe doit contenir au moins 8 caractères !";

        /*
        * Vérification de la confirmation du mot de passe
        */
        } elseif ($mdp !== $mdp2) {

            $erreur = "Vos mots de passe ne correspondent pas !";

        /*
        * Vérification de l'adresse mail
        */
        } elseif (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {

            $erreur = "Votre adresse mail n'est pas valide !";

        /*
        * Vérification de la confirmation du mail
        */
        } elseif ($mail !== $mail2) {

            $erreur = "Vos adresses mail ne correspondent pas !";

        } else {

            /*
            * Vérification de l'unicité du pseudo
            */
            $reqpseudo = $bdd->prepare(
                "SELECT id
                FROM membres
                WHERE pseudo = ?"
            );

            $reqpseudo->execute([$pseudo]);

            if ($reqpseudo->fetch()) {

                $erreur = "Ce pseudo est déjà utilisé !";

            } else {

                /*
                * Vérification de l'unicité du mail
                */
                $reqmail = $bdd->prepare(
                    "SELECT id
                    FROM membres
                    WHERE mail = ?"
                );

                $reqmail->execute([$mail]);

                if ($reqmail->fetch()) {

                    $erreur = "Cette adresse mail est déjà utilisée !";

                } else {

                    /*
                    * Hash sécurisé du mot de passe
                    *
                    * IMPORTANT :
                    * On ne stocke plus le mot de passe en SHA-1.
                    */
                    $motdepasseHash = password_hash(
                        $mdp,
                        PASSWORD_DEFAULT
                    );

                    /*
                    * Création du compte
                    */
                    $insertmbr = $bdd->prepare(
                        "INSERT INTO membres
                        (pseudo, mail, motdepasse)
                        VALUES (?, ?, ?)"
                    );

                    $insertmbr->execute([
                        $pseudo,
                        $mail,
                        $motdepasseHash
                    ]);

                    /*
                    * Redirection vers la connexion
                    */
                    header("Location: connexionControleur.php?inscription=ok");
                    exit;
                }
            }
        }
    }

}
/*
 * Préparation des messages
 */
if ($erreur !== null) {
    $messageErreur = '<div class="public-alert public-alert-danger">'
        . htmlspecialchars($erreur, ENT_QUOTES, 'UTF-8')
        . '</div>';
} else {
    $messageErreur = '';
}

$messageConfirmation = '';

/*
 * Indique à Vue que la page doit commencer
 * sur le formulaire d'inscription.
 */
$mode = 'register';

$csrfField = '<input type="hidden" name="csrf_token" value="'
    . htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8')
    . '">';

if (isset($_SESSION['id']) && !empty($_SESSION['id'])) {

    $menu = '
        <a href="../../Controleur/compte/profil.php">
            Mon profil
        </a>

        <a href="../../Controleur/messages/reception.php">
            Messages
        </a>

        <a href="../../Controleur/compte/deconnexion.php">
            Déconnexion
        </a>
    ';

} else {

    $menu = '
        <a href="../../Controleur/compte/connexionControleur.php">
            Me connecter
        </a>

        <a
            href="../../Controleur/compte/inscriControleur.php"
            class="register"
        >
            M\'inscrire
        </a>
    ';
}

$tbs->MergeField("menu", $menu);

/*
 * Envoi des données à TinyButStrong
 */

$tbs->MergeField("messageErreur", $messageErreur);
$tbs->MergeField("messageConfirmation", $messageConfirmation);
$tbs->MergeField("mode", $mode);
$tbs->MergeField("csrf_token", $_SESSION['csrf_token']);

/*
 * Affichage de la vue
 */
$tbs->LoadTemplate("../../Vue/compte/auth.php");
$tbs->Show();

?>