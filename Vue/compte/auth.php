<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Blog by S. - Connexion</title>

    <link rel="stylesheet" href="../../assets/css/style.css">
    <link rel="stylesheet" href="../../assets/css/auth.css">
    <link rel="stylesheet" href="../../assets/css/styleMenu.css">
    <link rel="stylesheet" href="../../assets/css/accueil.css">

</head>

<body>

    <nav class="public-navbar">

        <a
            href="../../Controleur/accueil.php"
            class="public-logo"
        >
            <img
                src="../../assets/images/logo.png"
                alt="Blog by S."
            >
        </a>

        <div class="public-nav-links">

            <a href="../../Controleur/accueil.php">
                Accueil
            </a>

            [onshow.menu;htmlconv=no]

        </div>

    </nav>

    <div id="auth-app" class="auth-page" data-mode="[onshow.mode]">

        <div class="auth-container" :class="{ 'show-register': mode === 'register' }">

            <!-- ==========================================
                PANNEAU VISUEL
                ========================================== -->

            <div class="auth-visual">

                <div class="visual-content">

                    <img
                        src="../../assets/images/logo.png"
                        alt="Blog by S."
                        class="auth-logo"
                    >

                    <div v-if="mode === 'login'">

                        <h1 class="titreBienvenue">Bienvenue 👋</h1>

                        <p>
                            Retrouvez votre espace et partagez
                            vos meilleurs moments avec la communauté.
                        </p>

                    </div>

                    <div v-else>

                        <h1 class="titreBienvenue">Rejoignez-nous ✨</h1>

                        <p>
                            Créez votre compte et commencez à partager
                            vos photos avec la communauté.
                        </p>

                    </div>

                </div>

            </div>


            <!-- ==========================================
                ZONE DES FORMULAIRES
                ========================================== -->

            <div class="auth-forms">


                <!-- ======================================
                    CONNEXION
                    ====================================== -->

                <div
                    class="auth-form login-form"
                    :class="{ active: mode === 'login' }"
                >

                    <div class="form-content">

                        <span class="form-label">BON RETOUR</span>

                        <h2>Se connecter</h2>

                        <p class="form-description">
                            Connectez-vous à votre compte Blog by S.
                        </p>


                        <!-- Message d'erreur -->

                        [onshow.messageErreur;htmlconv=no]


                        <!-- Confirmation inscription -->

                        [onshow.messageConfirmation;htmlconv=no]


                        <form
                            method="POST"
                            action="../../Controleur/compte/connexionControleur.php"
                        >
                            [onshow.csrfField;htmlconv=no]
                            <div class="input-group">

                                <label for="login-mail">
                                    Adresse mail
                                </label>

                                <input
                                    type="email"
                                    id="login-mail"
                                    name="mailconnect"
                                    placeholder="exemple@email.com"
                                    autocomplete="email"
                                    maxlength="255"
                                    required
                                >

                            </div>


                            <div class="input-group">

                                <label for="login-password">
                                    Mot de passe
                                </label>

                                <input
                                    type="password"
                                    id="login-password"
                                    name="mdpconnect"
                                    placeholder="Votre mot de passe"
                                    autocomplete="current-password"
                                    required
                                >

                            </div>


                            <button
                                type="submit"
                                name="formconnexion"
                                class="auth-button"
                            >
                                Se connecter
                            </button>

                        </form>


                        <div class="switch-text">

                            <span>
                                Pas encore de compte ?
                            </span>

                            <button
                                type="button"
                                class="switch-button"
                                @click="mode = 'register'"
                            >
                                Créer un compte
                            </button>

                        </div>

                    </div>

                </div>


                <!-- ======================================
                    INSCRIPTION
                    ====================================== -->

                <div
                    class="auth-form register-form"
                    :class="{ active: mode === 'register' }"
                >

                    <div class="form-content">

                        <span class="form-label">
                            NOUVEAU MEMBRE
                        </span>

                        <h2>Créer un compte</h2>

                        <p class="form-description">
                            Rejoignez la communauté Blog by S.
                        </p>


                        <!-- Message d'erreur inscription -->

                        [onshow.messageErreur;htmlconv=no]


                        <form
                            method="POST"
                            action="../../Controleur/compte/inscriControleur.php"
                        >
                            [onshow.csrfField;htmlconv=no]

                            <div class="input-group">

                                <label for="register-pseudo">
                                    Pseudo
                                </label>

                                <input
                                    type="text"
                                    id="register-pseudo"
                                    name="pseudo"
                                    placeholder="Votre pseudo"
                                    maxlength="255"
                                    required
                                >

                            </div>


                            <div class="input-group">

                                <label for="register-mail">
                                    Adresse mail
                                </label>

                                <input
                                    type="email"
                                    id="register-mail"
                                    name="mail"
                                    placeholder="exemple@email.com"
                                    maxlength="255"
                                    autocomplete="email"
                                    required
                                >

                            </div>


                            <div class="input-group">

                                <label for="register-mail2">
                                    Confirmer votre mail
                                </label>

                                <input
                                    type="email"
                                    id="register-mail2"
                                    name="mail2"
                                    placeholder="Confirmez votre adresse mail"
                                    maxlength="255"
                                    required
                                >

                            </div>


                            <div class="input-group">

                                <label for="register-password">
                                    Mot de passe
                                </label>

                                <input
                                    type="password"
                                    id="register-password"
                                    name="mdp"
                                    placeholder="8 caractères minimum"
                                    minlength="8"
                                    autocomplete="new-password"
                                    required
                                >

                            </div>


                            <div class="input-group">

                                <label for="register-password2">
                                    Confirmer le mot de passe
                                </label>

                                <input
                                    type="password"
                                    id="register-password2"
                                    name="mdp2"
                                    placeholder="Confirmez votre mot de passe"
                                    minlength="8"
                                    autocomplete="new-password"
                                    required
                                >

                            </div>


                            <button
                                type="submit"
                                name="forminscription"
                                class="auth-button"
                            >
                                Créer mon compte
                            </button>

                        </form>


                        <div class="switch-text">

                            <span>
                                Déjà membre ?
                            </span>

                            <button
                                type="button"
                                class="switch-button"
                                @click="mode = 'login'"
                            >
                                Se connecter
                            </button>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>


    <!-- Vue.js 3 -->

    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>

    <script src="../../assets/js/auth.js"></script>

</body>

</html>