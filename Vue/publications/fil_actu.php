<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Fil d'actualité - Blog by S.</title>

    <link rel="icon" href="../../assets/images/favicon.ico" type="image/x-icon">

    <link rel="stylesheet" href="../../assets/css/style.css">
    <link rel="stylesheet" href="../../assets/css/fil_actu.css">
</head>

<body>

<?php require_once(__DIR__ . '/../composants/menu.php'); ?>


<!-- Header -->
<header class="navbar pcoded-header navbar-expand-lg navbar-light header-dark">

    <div class="m-header">

        <a class="mobile-menu" id="mobile-collapse" href="#!">
            <span></span>
        </a>

        <a href="../../Controleur/compte/profil.php" class="b-brand">
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

</header>


<!-- Contenu principal -->
<main class="pcoded-main-container">

    <div class="pcoded-content">

        <!-- Breadcrumb -->
        <div class="page-header">

            <div class="page-block">

                <div class="row align-items-center">

                    <div class="col-md-12">

                        <div class="page-header-title">
                            <h5 class="m-b-10">Publications</h5>
                        </div>

                        <ul class="breadcrumb">

                            <li class="breadcrumb-item">
                                <a href="../../Controleur/compte/profil.php">
                                    <i class="feather icon-home"></i>
                                </a>
                            </li>

                            <li class="breadcrumb-item">
                                Fil d'actualité
                            </li>

                        </ul>

                    </div>

                </div>

            </div>

        </div>


        <!-- Fil d'actualité -->
        <div class="feed-page">

            <div class="feed-header">

                <div>
                    <h1>Fil d'actualité</h1>

                    <p>
                        Découvrez les dernières publications de la communauté.
                    </p>
                </div>

            </div>


            <?php if ($publications->rowCount() === 0): ?>

                <div class="feed-empty">

                    <div class="feed-empty-icon">
                        <i class="feather icon-users"></i>
                    </div>

                    <h2>Aucune publication</h2>

                    <p>
                        Il n'y a aucune publication à afficher pour le moment.
                    </p>

                </div>

            <?php else: ?>

                <div class="feed-grid">

                    <?php while ($a = $publications->fetch()): ?>

                        <article class="feed-card">

                            <!-- Image -->
                            <div class="feed-image-container">

                                <img
                                    src="../../miniatures/<?= (int) $a['id_photo'] ?>.jpg"
                                    alt="<?= htmlspecialchars(
                                        $a['titre'],
                                        ENT_QUOTES,
                                        'UTF-8'
                                    ) ?>"
                                    class="feed-image"
                                >

                            </div>


                            <!-- Informations -->
                            <div class="feed-content">

                                <!-- Auteur -->
                                <div class="feed-author">

                                    <div class="feed-author-icon">
                                        <i class="feather icon-user"></i>
                                    </div>

                                    <div class="feed-author-info">

                                        <span class="feed-author-name">
                                            <?= htmlspecialchars(
                                                $a['pseudo'],
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ) ?>
                                        </span>

                                        <span class="feed-date">
                                            <?= date(
                                                'd/m/Y à H:i',
                                                strtotime($a['date_time_publication'])
                                            ) ?>
                                        </span>

                                    </div>

                                </div>


                                <!-- Titre -->
                                <h2 class="feed-title">
                                    <?= htmlspecialchars(
                                        $a['titre'],
                                        ENT_QUOTES,
                                        'UTF-8'
                                    ) ?>
                                </h2>


                                <!-- Description -->
                                <?php if (!empty($a['description'])): ?>

                                    <p class="feed-description">
                                        <?= nl2br(
                                            htmlspecialchars(
                                                $a['contenu'],
                                                ENT_QUOTES,
                                                'UTF-8'
                                            )
                                        ) ?>
                                    </p>

                                <?php endif; ?>


                                <!-- Interactions -->
                                
                                <div class="feed-actions">

                                    <div class="like-container">
                                        <button
                                            type="button"
                                            class="feed-action like-action <?= !empty($a['utilisateur_aime']) ? 'liked' : '' ?>"
                                            data-publication="<?= (int) $a['id_photo'] ?>"
                                            data-connecte="<?= isset($_SESSION['id']) && !empty($_SESSION['id']) ? '1' : '0' ?>"
                                            title="J'aime"
                                            aria-label="J'aime"
                                        >
                                            <i class="feather icon-heart"></i>
                                        </button>
                                        <span
                                            class="like-count"
                                            id="like-count-<?= (int) $a['id_photo'] ?>"
                                        >
                                            <?= (int) $a['nombre_likes'] ?>
                                        </span>
                                    </div>


                                    <a
                                        href="../../Controleur/publications/commentaires.php?id=<?= (int) $a['id_photo'] ?>"
                                        class="feed-action comment-action"
                                        title="Commentaires"
                                        aria-label="Commentaires"
                                    >
                                        <i class="feather icon-message-circle"></i>
                                    </a>

                                </div>

                            </div>

                        </article>

                    <?php endwhile; ?>

                </div>

            <?php endif; ?>

        </div>

    </div>

</main>


<script src="../../assets/js/plugins/bootstrap.min.js"></script>
<script src="../../assets/js/pcoded.min.js"></script>

<script src="../../assets/js/vendor-all.min.js"></script>
<script src="../../assets/js/plugins/perfect-scrollbar.min.js"></script>

<script>
document.querySelectorAll('.like-action').forEach(function (bouton) {

    bouton.addEventListener('click', function () {

        if (this.dataset.connecte === '0') {
            alert('Vous devez être connecté pour aimer une publication.');
            return;
        }

        const idPublication = this.dataset.publication;

        const formulaire = new FormData();
        formulaire.append('id_publication', idPublication);

        fetch('../../Controleur/publications/like.php', {
            method: 'POST',
            body: formulaire
        })
        .then(function (response) {
            return response.json();
        })
        .then(function (data) {

            if (!data.success) {
                alert(data.message);
                return;
            }

            const compteur = document.getElementById(
                'like-count-' + idPublication
            );

            if (data.aime) {
                bouton.classList.add('liked');
            } else {
                bouton.classList.remove('liked');
            }

            if (compteur) {
                compteur.textContent = data.nombre_likes;
            }

        })
        .catch(function (error) {
            console.error('Erreur lors du like :', error);
        });

    });

});
</script>

</body>

</html>