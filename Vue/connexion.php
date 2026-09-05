<!DOCTYPE html>
<html lang="fr">

<head>

    <title>Connexion - Blog by S.</title>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/styleMenu.css">

</head>

<body class="public-auth-page">

    <!-- =========================
         NAVBAR
         ========================= -->

    <nav class="public-navbar">

        <a
            href="../Controleur/accueil.php"
            class="public-logo"
        >
            <img
                src="../assets/images/logo.png"
                alt="Blog by S."
            >
        </a>

        <div class="public-nav-links">

            <a href="../Controleur/accueil.php">
                Accueil
            </a>

            <a
                href="../Controleur/compte/connexionControleur.php"
                class="active"
            >
                Me connecter
            </a>

            <a
                href="../Controleur/compte/inscriControleur.php"
                class="register"
            >
                M'inscrire
            </a>

        </div>

    </nav>


    <!-- =========================
         CONNEXION
         ========================= -->

    <main class="public-auth-container">

        <div class="public-auth-card">

            <h1>Bienvenue 👋</h1>

            <p class="auth-subtitle">
                Connectez-vous à votre compte Blog by S.
            </p>


            [onshow.messageErreur;htmlconv=no]
            [onshow.messageConfirmation;htmlconv=no]


            <form
                method="POST"
                action="../Controleur/compte/connexionControleur.php"
                class="public-auth-form"
            >

                <div class="form-group">

                    <label for="mmail">
                        Adresse mail
                    </label>

                    <input
                        type="email"
                        id="mmail"
                        name="mailconnect"
                        placeholder="exemple@email.com"
                        autocomplete="email"
                        maxlength="255"
                        required
                    >

                </div>


                <div class="form-group">

                    <label for="mdp">
                        Mot de passe
                    </label>

                    <input
                        type="password"
                        id="mdp"
                        name="mdpconnect"
                        placeholder="Votre mot de passe"
                        autocomplete="current-password"
                        required
                    >

                </div>


                <button
                    type="submit"
                    name="formconnexion"
                    class="public-auth-button"
                >
                    Se connecter
                </button>

            </form>


            <div class="public-auth-divider"></div>


            <p class="public-auth-footer">

                Vous n'avez pas encore de compte ?

                <a href="../Controleur/compte/inscriControleur.php">
                    Créer un compte
                </a>

            </p>

        </div>

    </main>

</body>

</html>