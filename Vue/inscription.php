<!DOCTYPE html>
<html lang="fr">

<head>

    <title>Inscription - Blog by S.</title>

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

            <a href="../Controleur/connexionControleur.php">
                Me connecter
            </a>

            <a
                href="../Controleur/compte/inscriControleur.php"
                class="active"
            >
                M'inscrire
            </a>

        </div>

    </nav>


    <!-- =========================
         INSCRIPTION
         ========================= -->

    <main class="public-auth-container">

        <div class="public-auth-card">

            <h1>Créer un compte</h1>

            <p class="auth-subtitle">
                Rejoignez la communauté Blog by S.
            </p>


            <form
                method="POST"
                action="../Controleur/compte/inscriControleur.php"
                class="public-auth-form"
            >

                <div class="form-group">

                    <label for="pseudo">
                        Pseudo
                    </label>

                    <input
                        type="text"
                        id="pseudo"
                        name="pseudo"
                        placeholder="Votre pseudo"
                        maxlength="255"
                        autocomplete="username"
                        required
                    >

                </div>


                <div class="form-group">

                    <label for="mail">
                        Adresse mail
                    </label>

                    <input
                        type="email"
                        id="mail"
                        name="mail"
                        placeholder="exemple@email.com"
                        maxlength="255"
                        autocomplete="email"
                        required
                    >

                </div>


                <div class="form-group">

                    <label for="mail2">
                        Confirmer votre adresse mail
                    </label>

                    <input
                        type="email"
                        id="mail2"
                        name="mail2"
                        placeholder="Retapez votre adresse mail"
                        maxlength="255"
                        autocomplete="email"
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
                        name="mdp"
                        placeholder="8 caractères minimum"
                        minlength="8"
                        autocomplete="new-password"
                        required
                    >

                </div>


                <div class="form-group">

                    <label for="mdp2">
                        Confirmer votre mot de passe
                    </label>

                    <input
                        type="password"
                        id="mdp2"
                        name="mdp2"
                        placeholder="Retapez votre mot de passe"
                        minlength="8"
                        autocomplete="new-password"
                        required
                    >

                </div>


                <button
                    type="submit"
                    name="forminscription"
                    class="public-auth-button"
                >
                    Créer mon compte
                </button>

            </form>


            <div class="public-auth-divider"></div>


            <p class="public-auth-footer">

                Vous avez déjà un compte ?

                <a href="../Controleur/compte/connexionControleur.php">
                    Se connecter
                </a>

            </p>

        </div>

    </main>

</body>

</html>