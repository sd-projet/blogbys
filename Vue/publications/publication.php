
<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Mes publications - Blog by S.</title>

    <link rel="icon" href="../../assets/images/favicon.ico" type="image/x-icon">

    <link rel="stylesheet" href="../../assets/css/style.css">
    <link rel="stylesheet" href="../../assets/css/publication.css">

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
                                Publications
                            </h5>

                        </div>

                        <ul class="breadcrumb">

                            <li class="breadcrumb-item">

                                <a href="../../Controleur/compte/profil.php">
                                    <i class="feather icon-home"></i>
                                </a>

                            </li>

                            <li class="breadcrumb-item">
                                Mes publications
                            </li>

                        </ul>

                    </div>

                </div>

            </div>

        </div>


        <!-- =========================
             PAGE
             ========================= -->

        <div class="publication-page">

            <div class="publication-header">

                <div>

                    <h1>
                        Mes publications
                    </h1>

                    <p>
                        Retrouvez toutes les publications que vous avez partagées.
                    </p>

                </div>


                <a
                    href="../../Controleur/publications/RedactionControleur.php"
                    class="publication-add-button"
                >
                    <i class="feather icon-plus"></i>
                    <span>Nouvelle publication</span>
                </a>

            </div>


            <!-- =========================
                 GALERIE
                 ========================= -->

            <div class="publication-grid">

                <?php while ($a = $publications->fetch()) : ?>

                    <article class="publication-card">


                        <!-- IMAGE -->

                        <div class="publication-image-container">

                            <img
                                src="../../miniatures/<?= (int) $a['id_photo'] ?>.jpg"
                                alt="<?= htmlspecialchars(
                                    $a['titre'],
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>"
                                class="publication-image"
                            >

                        </div>


                        <!-- CONTENU -->

                        <div class="publication-content">

                            <h2 class="publication-title">

                                <?= htmlspecialchars(
                                    $a['titre'],
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>

                            </h2>

                            <p>

                                <?= htmlspecialchars(
                                    $a['contenu'],
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>

                            </p>
                            <!-- STATISTIQUES -->
                            <div class="publication-date">

                                <i class="feather icon-calendar"></i>

                                <?= date(
                                    'd/m/Y à H:i',
                                    strtotime($a['date_time_publication'])
                                ) ?>

                            </div>
                            <div class="publication-stats">

                                <span class="publication-stat">
                                    <i class="feather icon-heart"></i>
                                    <?= (int) $a['nombre_likes'] ?>
                                </span>

                                <span class="publication-stat">
                                    <i class="feather icon-message-circle"></i>
                                    <?= (int) $a['nombre_commentaires'] ?>
                                </span>

                            </div>
                            

                            <!-- ACTIONS -->

                            <div class="publication-actions">

                                <!-- Modifier -->

                                <a
                                    href="../../Controleur/publications/RedactionControleur.php?edit=<?= (int) $a['id_photo'] ?>"
                                    class="publication-action publication-edit"
                                    title="Modifier la publication"
                                    aria-label="Modifier la publication"
                                >
                                    <i class="feather icon-edit-2"></i>
                                </a>


                                <!-- Voir les avis -->
                                <a
                                    href="../../Controleur/publications/commentaires.php?id=<?= (int) $a['id_photo'] ?>"
                                    class="publication-action publication-comments"
                                    title="Voir"
                                    aria-label="Voir"
                                >
                                    <i class="feather icon-message-circle"></i>
                                </a>

                                <!-- Supprimer -->

                                <form
                                    method="POST"
                                    action="../../Controleur/publications/supprimer.php"
                                    onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette publication ?');"
                                >
                                    <input
                                        type="hidden"
                                        name="csrf_token"
                                        value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                                    >

                                    <input
                                        type="hidden"
                                        name="id"
                                        value="<?= (int) $a['id_photo'] ?>"
                                    >

                                    <button
                                        type="submit"
                                        class="publication-action publication-delete"
                                        title="Supprimer la publication"
                                        aria-label="Supprimer la publication"
                                    >
                                        <i class="feather icon-trash-2"></i>
                                    </button>

                                </form>

                            </div>

                        </div>

                    </article>

                <?php endwhile; ?>

            </div>

        </div>

    </div>

</main>


<script src="../../assets/js/plugins/bootstrap.min.js"></script>
<script src="../../assets/js/pcoded.min.js"></script>

</body>

</html>
