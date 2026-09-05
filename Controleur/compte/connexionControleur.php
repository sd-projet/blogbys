<?php

session_start();

require("../../BaseDonnee/connect.php");
require("../../tbs_3132/tbs_class.php");
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
 * Vérification du formulaire de connexion
 */
if (isset($_POST['formconnexion'])) {

    if (
        !isset($_POST['csrf_token']) ||
        !verifierCSRF($_POST['csrf_token'])
    ) {
        $erreur = "Requête invalide. Veuillez réessayer.";
    } else {
        $mailconnect = trim($_POST['mailconnect'] ?? '');
        $mdpconnect = $_POST['mdpconnect'] ?? '';

        /*
        * Vérification des champs
        */
        if (empty($mailconnect) || empty($mdpconnect)) {

            $erreur = "Tous les champs doivent être complétés !";

        } elseif (!filter_var($mailconnect, FILTER_VALIDATE_EMAIL)) {

            $erreur = "Votre adresse mail n'est pas valide !";

        } else {

            /*
            * Recherche de l'utilisateur uniquement avec son mail.
            *
            * Le mot de passe sera vérifié avec password_verify().
            */
            $requser = $bdd->prepare(
                "SELECT *
                FROM membres
                WHERE mail = ?"
            );

            $requser->execute([
                $mailconnect
            ]);

            $userinfo = $requser->fetch();

            /*
            * Vérification du mot de passe
            */
            if (
                $userinfo &&
                password_verify(
                    $mdpconnect,
                    $userinfo['motdepasse']
                )
            ) {

                /*
                * Nouvelle session après connexion
                * pour éviter la fixation de session.
                */
                session_regenerate_id(true);

                $_SESSION['id'] = $userinfo['id'];
                $_SESSION['pseudo'] = $userinfo['pseudo'];
                $_SESSION['mail'] = $userinfo['mail'];

                header("Location: profil.php");
                exit;

            } else {

                /*
                * Message volontairement général :
                * on ne précise pas si le mail ou le mot de passe
                * est incorrect.
                */
                $erreur = "Mauvais mail ou mot de passe !";
            }
        }
    }
}

$confirmation = null;

if (isset($_GET['inscription']) && $_GET['inscription'] === 'ok') {
    $confirmation = "Votre compte a été créé avec succès. Vous pouvez maintenant vous connecter.";
}

if ($erreur !== null) {
    $messageErreur = '<div class="alert alert-danger">'
        . htmlspecialchars($erreur, ENT_QUOTES, 'UTF-8')
        . '</div>';
} else {
    $messageErreur = '';
}

if ($confirmation !== null) {
    $messageConfirmation = '<div class="alert alert-success">'
        . htmlspecialchars($confirmation, ENT_QUOTES, 'UTF-8')
        . '</div>';
} else {
    $messageConfirmation = '';
}

$mode = 'login';

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

/*
 * Affichage de la vue
 */

$tbs->MergeField("menu", $menu);

$tbs->MergeField("csrfField", $csrfField);

$tbs->MergeField("messageErreur", $messageErreur);
$tbs->MergeField("messageConfirmation", $messageConfirmation);

$tbs->MergeField("mode", $mode);

//$tbs->LoadTemplate("../Vue/connexion.php");
$tbs->LoadTemplate("../../Vue/compte/auth.php");
$tbs->Show();

?>
