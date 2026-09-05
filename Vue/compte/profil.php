<!DOCTYPE html>

<html lang="fr">

    <head>

    <title>Mon compte - Blog by S.</title>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" href="../../assets/images/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="../../assets/css/style.css">
    <link rel="stylesheet" href="../../assets/css/profil.css">


    </head>

    <body>

        <!-- =========================
            MENU
            ========================= -->

        <?php require_once(__DIR__ . '/../composants/menu.php'); ?>


        <!-- =========================
            HEADER
            ========================= -->
        <header class="navbar pcoded-header navbar-expand-lg navbar-light header-dark">
            <div class="m-header">

                <a class="mobile-menu" id="mobile-collapse" href="#!">
                <span></span>
                </a>

                <a href="../accueil.php" class="b-brand">
                    <img
                        src="../../assets/images/logo.png"
                        alt="Blog by S."
                        class="logo"
                    >
                </a>

                <a href="#!" class="mob-toggler">
                    <i class="feather icon-more-vertical"></i>
                </a>

            </div>

            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ml-auto">
                    <li>
                        <div class="dropdown drp-user">
                            <a
                                href="#!"
                                class="dropdown-toggle"
                                data-toggle="dropdown"
                            >
                                <i class="feather icon-user"></i>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right profile-notification">
                                <div class="pro-head">
                                    <i class="feather icon-user"></i>
                                    <span>
                                        <?= htmlspecialchars($pseudo, ENT_QUOTES, 'UTF-8') ?>
                                    </span>

                                    <a
                                        href="../../Controleur/compte/deconnexion.php"
                                        class="dud-logout"
                                        title="Se déconnecter"
                                    >
                                        <i class="feather icon-log-out"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </header>

        <!-- =========================
            CONTENU PRINCIPAL
            ========================= -->

        <div class="pcoded-main-container">
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
                                        Profil
                                    </h5>
                                </div>

                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="../accueil.php">
                                            <i class="feather icon-home"></i>
                                        </a>
                                    </li>

                                    <li class="breadcrumb-item">
                                        <a href="#!">Profil</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- =========================
                    PROFIL
                    ========================= -->

                <div class="profile-page">
                    <!-- Présentation -->
                    <div class="account-profile-card">

                        <div class="profile-avatar">
                            <i class="feather icon-user"></i>
                        </div>
                        
                        <div class="profile-info">
                            <div class="profile-details-header">

                                <div>
                                    <h3>
                                        Informations du compte
                                    </h3>

                                    <p>
                                        Consultez les informations associées à votre compte.
                                    </p>

                                </div>
                                <a
                                    href="../../Controleur/compte/editionprofil.php"
                                    class="profile-edit-button"
                                >
                                    <i class="feather icon-edit-2"></i>
                                    Modifier
                                </a>

                            </div>
                            
                            <div class="profile-details-grid">
                                <div class="profile-detail">
                                    <span>
                                        Pseudo
                                    </span>
                                    <strong>
                                        <?= htmlspecialchars(
                                            $pseudo,
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ) ?>
                                    </strong>
                                </div>

                                <div class="profile-detail">
                                    <span>
                                        Adresse mail
                                    </span>

                                    <strong>
                                        <?= htmlspecialchars(
                                            $mail,
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ) ?>
                                    </strong>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Statistiques -->

                    <div class="profile-stats">

                        <div class="profile-stat-card">

                            <div class="profile-stat-icon">
                                <i class="feather icon-image"></i>
                            </div>

                            <div>

                                <strong>
                                    <?= $nombrePublications ?>
                                </strong>

                                <span>
                                    Publication<?= $nombrePublications > 1 ? 's' : '' ?>
                                </span>

                            </div>

                        </div>


                        <div class="profile-stat-card">

                            <div class="profile-stat-icon">
                                <i class="feather icon-heart"></i>
                            </div>

                            <div>

                                <strong>
                                    <?= $nombreLikes ?>
                                </strong>

                                <span>
                                    Like<?= $nombreLikes > 1 ? 's' : '' ?> reçu<?= $nombreLikes > 1 ? 's' : '' ?>
                                </span>

                            </div>

                        </div>


                        <div class="profile-stat-card">

                            <div class="profile-stat-icon">
                                <i class="feather icon-message-circle"></i>
                            </div>

                            <div>

                                <strong>
                                    <?= $nombreCommentaires ?>
                                </strong>

                                <span>
                                    Commentaire<?= $nombreCommentaires > 1 ? 's' : '' ?> reçu<?= $nombreCommentaires > 1 ? 's' : '' ?>
                                </span>

                            </div>

                        </div>

                    </div>

                </div>
            </div>
        </div>

        <!-- =========================
            JAVASCRIPT
            ========================= -->

        <script src="../../assets/js/vendor-all.min.js"></script>
        <script src="../../assets/js/plugins/bootstrap.min.js"></script>
        <script src="../../assets/js/plugins/perfect-scrollbar.min.js"></script>
        <script src="../../assets/js/pcoded.min.js"></script>

    </body>

</html>
