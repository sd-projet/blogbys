<!DOCTYPE html>
<html lang="fr">

<head>

    <title>Accueil - Partagez vos photos</title>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" href="../assets/images/favicon.ico" type="image/x-icon">

    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/styleMenu.css">
    <link rel="stylesheet" href="../assets/css/accueil.css">
    <link rel="stylesheet" href="../assets/css/fil_actu.css">

</head>

<body class="public-page">

    <!-- =========================
         NAVBAR
         ========================= -->
    <?php
    var_dump($_SESSION['id'] ?? null);
    ?>
    <nav class="public-navbar">

        <a href="../Controleur/accueil.php" class="public-logo">
            <img src="../assets/images/logo.png" alt="Blog by S.">
        </a>

        <div class="public-nav-links">

            <a
                href="../Controleur/accueil.php"
                class="active"
            >
                Accueil
            </a>
            [onshow.menu;htmlconv=no]


        </div>

    </nav>


    <!-- =========================
         HERO
         ========================= -->

    <section class="public-hero">

        <h1>
            Partagez vos <span>photos</span>
        </h1>

        <p>
            Découvrez les publications de notre communauté,
            partagez vos meilleurs moments et laissez parler votre créativité.
        </p>

        <div class="hero-buttons">

            <a
                href="../Controleur/compte/inscriControleur.php"
                class="hero-button primary"
            >
                Créer un compte
            </a>

            <a
                href="../Controleur/compte/connexionControleur.php"
                class="hero-button secondary"
            >
                Se connecter
            </a>

        </div>

    </section>


    <!-- =========================
         PUBLICATIONS
         ========================= -->

    <section class="publications-section">

        <div class="publications-header">

            <h2>Dernières publications</h2>

            <p>
                Découvrez les dernières photos partagées par la communauté.
            </p>

        </div>


        <div class="feed-grid">

            [articles;block=begin]

            <article class="feed-card">

                <div class="feed-image-container">

                    <img
                        src="../miniatures/[articles.id_photo].jpg"
                        alt="[articles.titre]"
                        class="feed-image"
                    >

                </div>

                <div class="feed-content">

                    <div class="feed-author">

                        <div class="feed-author-icon">
                            <i class="feather icon-user"></i>
                        </div>

                        <div class="feed-author-info">

                            <span class="feed-author-name">
                                [articles.pseudo]
                            </span>

                            <span class="feed-date">
                                [articles.date_formatee]
                            </span>

                        </div>

                    </div>

                    <h2 class="feed-title">
                        [articles.titre]
                    </h2>

                    <p class="feed-description">
                        [articles.contenu]
                    </p>

                    <div class="feed-actions">

                        <div class="like-container">

                            <button
                                type="button"
                                class="feed-action like-action [articles.classe_like]"
                                data-publication="[articles.id_photo]"
                                data-connecte="[articles.utilisateur_connecte]"
                                title="J'aime"
                                aria-label="J'aime"
                            >
                                <i class="feather icon-heart"></i>
                            </button>

                            <span
                                class="like-count"
                                id="like-count-[articles.id_photo]"
                            >
                                [articles.nombre_likes]
                            </span>

                        </div>

                        <a
                            href="../Controleur/publications/commentaires.php?id=[articles.id_photo]"
                            class="feed-action comment-action"
                            title="Commentaires"
                            aria-label="Commentaires"
                        >
                            <i class="feather icon-message-circle"></i>
                        </a>

                    </div>
                </div>

            </article>

            [articles;block=end]

        </div>

    </section>


    <script src="../assets/js/plugins/bootstrap.min.js"></script>
    <script src="../assets/js/pcoded.min.js"></script>

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

        fetch('../Controleur/publications/like.php', {
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