<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Modifier mon profil - Blog by S.</title>

    <link
        rel="icon"
        href="../../assets/images/favicon.ico"
        type="image/x-icon"
    >

    <link
        rel="stylesheet"
        href="../../assets/css/style.css"
    >

    <link
        rel="stylesheet"
        href="../../assets/css/profil.css"
    >

</head>

<body>

    <?php require_once(__DIR__ . '/../composants/menu.php'); ?>


    <!-- =========================
        HEADER
        ========================= -->

    <header class="navbar pcoded-header navbar-expand-lg navbar-light header-dark">

        <div class="m-header">

            <a
                class="mobile-menu"
                id="mobile-collapse"
                href="#!"
            >
                <span></span>
            </a>

            <a
                href="../../Controleur/compte/profil.php"
                class="b-brand"
            >
                <img
                    src="../../assets/images/logo.png"
                    alt="Blog by S."
                    class="logo"
                >
            </a>

            <a
                href="#!"
                class="mob-toggler"
            >
                <i class="feather icon-more-vertical"></i>
            </a>

        </div>

    </header>


    <!-- =========================
        CONTENU
        ========================= -->

    <main class="pcoded-main-container">

        <div class="pcoded-content">


            <!-- =========================
                BREADCRUMB
                ========================= -->

            <div class="page-header">

                <div class="page-block">

                    <div class="row align-items-center">

                        <div class="col-md-12">

                            <div class="page-header-title">

                                <h5 class="m-b-10">
                                    Modifier mon profil
                                </h5>

                            </div>

                            <ul class="breadcrumb">

                                <li class="breadcrumb-item">

                                    <a href="../../Controleur/compte/profil.php">
                                        <i class="feather icon-home"></i>
                                    </a>

                                </li>

                                <li class="breadcrumb-item">

                                    <a href="../../Controleur/compte/profil.php">
                                        Profil
                                    </a>

                                </li>

                                <li class="breadcrumb-item">
                                    Modifier mes informations
                                </li>

                            </ul>

                        </div>

                    </div>

                </div>

            </div>


            <!-- =========================
                FORMULAIRE
                ========================= -->

            <div class="account-edit-page">

                <div class="account-edit-card">

                    <div class="account-edit-header">

                        <div class="account-edit-icon">
                            <i class="feather icon-user"></i>
                        </div>

                        <div>

                            <h1>
                                Modifier mes informations
                            </h1>

                            <p>
                                Modifiez les informations associées à votre compte.
                            </p>

                        </div>

                    </div>


                    <!-- Messages -->

                    <?php if ($messageErreur !== null) : ?>

                        <div class="account-message account-message-error">

                            <i class="feather icon-alert-circle"></i>

                            <span>
                                <?= htmlspecialchars(
                                    $messageErreur,
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>
                            </span>

                        </div>

                    <?php endif; ?>


                    <?php if ($messageConfirmation !== null) : ?>

                        <div class="account-message account-message-success">

                            <i class="feather icon-check-circle"></i>

                            <span>
                                <?= htmlspecialchars(
                                    $messageConfirmation,
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>
                            </span>

                        </div>

                    <?php endif; ?>


                    <form
                        method="POST"
                        action=""
                        class="account-edit-form"
                    >

                        <!-- Informations générales -->

                        <div class="account-section">

                            <div class="account-section-title">

                                <i class="feather icon-user"></i>

                                <div>

                                    <h2>
                                        Informations personnelles
                                    </h2>

                                    <p>
                                        Modifiez votre pseudo ou votre adresse mail.
                                    </p>

                                </div>

                            </div>


                            <div class="account-form-grid">

                                <div class="form-group">

                                    <label for="pseudo">
                                        Pseudo
                                    </label>

                                    <input
                                        type="text"
                                        class="form-control"
                                        id="pseudo"
                                        name="newpseudo"
                                        value="<?= htmlspecialchars(
                                            $pseudo,
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ) ?>"
                                        maxlength="255"
                                        required
                                    >

                                </div>


                                <div class="form-group">

                                    <label for="mail">
                                        Adresse mail
                                    </label>

                                    <input
                                        type="email"
                                        class="form-control"
                                        id="mail"
                                        name="newmail"
                                        value="<?= htmlspecialchars(
                                            $mail,
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ) ?>"
                                        maxlength="255"
                                        required
                                    >

                                </div>

                            </div>

                        </div>


                        <!-- Mot de passe -->

                        <div class="account-section">

                            <div class="account-section-title">

                                <i class="feather icon-lock"></i>

                                <div>

                                    <h2>
                                        Modifier le mot de passe
                                    </h2>

                                    <p>
                                        Laissez ces champs vides si vous ne souhaitez pas modifier votre mot de passe.
                                    </p>

                                </div>

                            </div>


                            <div class="account-form-grid">

                                <div class="form-group">

                                    <label for="mdp">
                                        Nouveau mot de passe
                                    </label>

                                    <input
                                        type="password"
                                        class="form-control"
                                        name="newmdp1"
                                        id="mdp"
                                        placeholder="••••••••"
                                        minlength="8"
                                    >

                                </div>


                                <div class="form-group">

                                    <label for="mdp2">
                                        Confirmer le mot de passe
                                    </label>

                                    <input
                                        type="password"
                                        class="form-control"
                                        id="mdp2"
                                        name="newmdp2"
                                        placeholder="••••••••"
                                        minlength="8"
                                    >

                                </div>

                            </div>

                        </div>


                        <!-- Actions -->

                        <div class="account-edit-actions">

                            <a
                                href="../../Controleur/compte/profil.php"
                                class="account-cancel-button"
                            >
                                Annuler
                            </a>

                            <button
                                type="submit"
                                name="modifierprofil"
                                class="account-save-button"
                            >
                                <i class="feather icon-save"></i>
                                Enregistrer les modifications
                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </main>


    <script src="../../assets/js/plugins/bootstrap.min.js"></script>
    <script src="../../assets/js/pcoded.min.js"></script>

</body>

</html>