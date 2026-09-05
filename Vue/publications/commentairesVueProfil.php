<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="utf-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        <?= htmlspecialchars(
            $publication['titre'],
            ENT_QUOTES,
            'UTF-8'
        ) ?>
        - Blog by S.
    </title>

    <link
        rel="icon"
        href="../../assets/images/favicon.ico"
        type="image/x-icon"
    >

    <link rel="stylesheet" href="../../assets/css/style.css">
    <link rel="stylesheet" href="../../assets/css/styleMenu.css">
    <link rel="stylesheet" href="../../assets/css/accueil.css">
    <link rel="stylesheet" href="../../assets/css/commentaires.css">

</head>


<body>


<?php if (isset($_SESSION['id']) && !empty($_SESSION['id'])): ?>

    <!-- Menu utilisateur connecté -->
    <?php require_once(__DIR__ . '/../composants/menu.php'); ?>

    <!-- Header utilisateur connecté -->
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

<?php else: ?>

    <!-- Navigation publique -->
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

            <a
                href="../../Controleur/accueil.php"
            >
                Accueil
            </a>

            <a
                href="../../Controleur/connexionControleur.php"
            >
                Me connecter
            </a>

            <a
                href="../../Controleur/compte/inscriControleur.php"
                class="register"
            >
                M'inscrire
            </a>

        </div>

    </nav>

<?php endif; ?>

<!-- Contenu principal -->
<main class="pcoded-main-container">

    <div class="pcoded-content">


        <!-- Breadcrumb -->
        <?php if (isset($_SESSION['id']) && !empty($_SESSION['id'])): ?>

            <!-- Breadcrumb uniquement pour les utilisateurs connectés -->
            <div class="page-header">

                <div class="page-block">

                    <div class="row align-items-center">

                        <div class="col-md-12">

                            <div class="page-header-title">
                                <h5 class="m-b-10">
                                    Commentaires
                                </h5>
                            </div>

                            <ul class="breadcrumb">

                                <li class="breadcrumb-item">
                                    <a href="../../Controleur/compte/profil.php">
                                        <i class="feather icon-home"></i>
                                    </a>
                                </li>

                                <li class="breadcrumb-item">

                                    <a href="../../Controleur/publications/actu.php">
                                        Fil d'actualité
                                    </a>

                                </li>

                                <li class="breadcrumb-item">
                                    Commentaires
                                </li>

                            </ul>

                        </div>

                    </div>

                </div>

            </div>

        <?php endif; ?>

        <div class="comments-back">

            <?php if (isset($_SESSION['id']) && !empty($_SESSION['id'])): ?>

                <a
                    href="../../Controleur/publications/actu.php"
                    class="comments-back-button"
                >
                    <i class="feather icon-arrow-left"></i>
                    Retour au fil d'actualité
                </a>

            <?php else: ?>

                <a
                    href="../../Controleur/accueil.php"
                    class="comments-back-button"
                >
                    <i class="feather icon-arrow-left"></i>
                    Retour à l'accueil
                </a>

            <?php endif; ?>

        </div>

        <!-- Page commentaires -->
        <div class="comments-page">

            <!-- Publication -->
            <article class="publication-detail">

                <!-- Image -->
                <div class="publication-detail-image">

                    <img
                        src="../../miniatures/<?= (int) $publication['id_photo'] ?>.jpg"
                        alt="<?= htmlspecialchars(
                            $publication['titre'],
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>"
                    >

                </div>

                <!-- Informations -->
                <div class="publication-detail-content">

                    <!-- Auteur -->
                    <div class="publication-author">

                        <div class="publication-author-icon">
                            <i class="feather icon-user"></i>
                        </div>

                        <div class="publication-author-info">

                            <span class="publication-author-name">
                                <?= htmlspecialchars(
                                    $publication['pseudo'],
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>
                            </span>

                            <span class="publication-date">
                                <?= date(
                                    'd/m/Y à H:i',
                                    strtotime(
                                        $publication['date_time_publication']
                                    )
                                ) ?>
                            </span>

                        </div>

                    </div>

                    <!-- Titre -->
                    <h1>
                        <?= htmlspecialchars(
                            $publication['titre'],
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>
                    </h1>

                    <!-- Description -->
                    <?php if (!empty($publication['contenu'])): ?>

                        <p>
                            <?= nl2br(
                                htmlspecialchars(
                                    $publication['contenu'],
                                    ENT_QUOTES,
                                    'UTF-8'
                                )
                            ) ?>
                        </p>
                    <?php endif; ?>
                </div>

            </article>

            <!-- Commentaires -->
            <section class="comments-section">
                <div class="comments-header">
                    <div>
                        <h2>
                            <i class="feather icon-message-circle"></i>
                            Commentaires
                        </h2>
                        <p>
                            <?= count($commentaires) ?>
                            commentaire<?= count($commentaires) > 1 ? 's' : '' ?>
                        </p>
                    </div>
                </div>

                <!-- Message -->
                <?php if ($messageCommentaire): ?>

                    <div
                        class="comment-message <?= $messageCommentaire['type'] === 'success'
                            ? 'comment-success'
                            : 'comment-error' ?>"
                    >

                        <i class="feather
                            <?= $messageCommentaire['type'] === 'success'
                                ? 'icon-check-circle'
                                : 'icon-alert-circle' ?>">
                        </i>

                        <span>
                            <?= htmlspecialchars(
                                $messageCommentaire['texte'],
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>
                        </span>

                    </div>

                <?php endif; ?>

                <!-- Formulaire -->
                <?php if (isset($_SESSION['id']) && !empty($_SESSION['id'])): ?>

                   <div class="comment-form-card">

                        <h3 class="comment-form-title">
                            <i class="feather icon-edit-3"></i>
                            Laisser un commentaire
                        </h3>

                        <p class="comment-form-user">
                            Connecté en tant que
                            <strong>
                                <?= htmlspecialchars(
                                    $_SESSION['pseudo'],
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>
                            </strong>
                        </p>

                        <form method="POST">

                            <textarea
                                name="commentaire"
                                class="form-control"
                                rows="4"
                                maxlength="1000"
                                placeholder="Écrivez votre commentaire..."
                                required
                            ></textarea>

                            <div class="comment-form-footer">

                                <span class="comment-counter">
                                    1000 caractères maximum
                                </span>

                                <button
                                    type="submit"
                                    class="comment-submit"
                                >
                                    <i class="feather icon-send"></i>
                                    Publier
                                </button>

                            </div>

                        </form>

                    </div>

                <?php else: ?>

                    <div class="comment-login-message">

                        <i class="feather icon-lock"></i>

                        <p>
                            Vous devez être connecté pour laisser un commentaire.
                        </p>

                        <a href="../../Controleur/compte/connexionControleur.php">
                            Se connecter
                        </a>

                    </div>

                <?php endif; ?>

                <!-- Liste des commentaires -->
                <div class="comments-list">

                    <?php if (empty($commentaires)): ?>

                        <div class="comments-empty">
                            <i class="feather icon-message-circle"></i>
                            <p>Aucun commentaire pour le moment.</p>
                        </div>

                   <?php else: ?>

                        <?php foreach ($commentaires as $commentaire): ?>

                            <article class="comment-card">

                                <div class="comment-avatar">
                                    <i class="feather icon-user"></i>
                                </div>


                                <div class="comment-content">

                                    <div class="comment-header">

                                        <strong>
                                            <?= htmlspecialchars(
                                                $commentaire['pseudo'],
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ) ?>
                                        </strong>


                                        <?php if (
                                            isset($_SESSION['id']) &&
                                            !empty($_SESSION['id']) &&
                                            !empty($commentaire['id_memb']) &&
                                            (int) $_SESSION['id'] === (int) $commentaire['id_memb']
                                        ): ?>

                                            <div class="comment-actions">

                                                <button
                                                    type="button"
                                                    class="comment-action comment-edit"
                                                    title="Modifier"
                                                    aria-label="Modifier"
                                                    onclick="modifierCommentaire(<?= (int) $commentaire['id_comm'] ?>)"
                                                >
                                                    <i class="feather icon-edit-2"></i>
                                                </button>


                                                <form
                                                    method="POST"
                                                    action="supprimerCommentaire.php"
                                                    onsubmit="return confirm('Voulez-vous vraiment supprimer ce commentaire ?');"
                                                >
                                                    <input
                                                        type="hidden"
                                                        name="csrf_token"
                                                        value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                                                    >
                                                    <input
                                                        type="hidden"
                                                        name="id_comm"
                                                        value="<?= (int) $commentaire['id_comm'] ?>"
                                                    >

                                                    <button
                                                        type="submit"
                                                        class="comment-action comment-delete"
                                                        title="Supprimer"
                                                        aria-label="Supprimer"
                                                    >
                                                        <i class="feather icon-trash-2"></i>
                                                    </button>

                                                </form>

                                            </div>

                                        <?php endif; ?>

                                    </div>


                                    <!-- Affichage normal -->
                                    <div
                                        class="comment-display"
                                        id="comment-display-<?= (int) $commentaire['id_comm'] ?>"
                                    >

                                        <p>
                                            <?= nl2br(
                                                htmlspecialchars(
                                                    $commentaire['commentaire'],
                                                    ENT_QUOTES,
                                                    'UTF-8'
                                                )
                                            ) ?>
                                        </p>

                                    </div>


                                    <!-- Formulaire de modification caché -->
                                    <?php if (
                                        isset($_SESSION['id']) &&
                                        !empty($_SESSION['id']) &&
                                        !empty($commentaire['id_memb']) &&
                                        (int) $_SESSION['id'] === (int) $commentaire['id_memb']
                                    ): ?>

                                        <form
                                            method="POST"
                                            action="modifierCommentaire.php"
                                            class="comment-edit-form"
                                            id="comment-edit-<?= (int) $commentaire['id_comm'] ?>"
                                            style="display: none;"
                                        >
                                            <input
                                                type="hidden"
                                                name="id_comm"
                                                value="<?= (int) $commentaire['id_comm'] ?>"
                                            >
                                            <textarea
                                                name="commentaire"
                                                class="form-control comment-edit-textarea"
                                                rows="4"
                                                maxlength="1000"
                                                required
                                            ><?= htmlspecialchars(
                                                $commentaire['commentaire'],
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ) ?></textarea>


                                            <div class="comment-edit-actions">

                                                <button
                                                    type="button"
                                                    class="comment-cancel"
                                                    onclick="annulerModification(<?= (int) $commentaire['id_comm'] ?>)"
                                                >
                                                    Annuler
                                                </button>

                                                <button
                                                    type="submit"
                                                    class="comment-submit"
                                                >
                                                    <i class="feather icon-check"></i>
                                                    Enregistrer
                                                </button>

                                            </div>

                                        </form>

                                    <?php endif; ?>

                                </div>

                            </article>

                        <?php endforeach; ?>

                    <?php endif; ?>
                </div>

            </section>

        </div>

    </div>

</main>


<script src="../../assets/js/plugins/bootstrap.min.js"></script>
<script src="../../assets/js/pcoded.min.js"></script>

<script>
function modifierCommentaire(id) {

    const affichage = document.getElementById(
        'comment-display-' + id
    );

    const formulaire = document.getElementById(
        'comment-edit-' + id
    );

    if (!affichage || !formulaire) {
        return;
    }

    affichage.style.display = 'none';
    formulaire.style.display = 'block';

    const textarea = formulaire.querySelector('textarea');

    if (textarea) {
        textarea.focus();

        textarea.setSelectionRange(
            textarea.value.length,
            textarea.value.length
        );
    }
}


function annulerModification(id) {

    const affichage = document.getElementById(
        'comment-display-' + id
    );

    const formulaire = document.getElementById(
        'comment-edit-' + id
    );

    if (!affichage || !formulaire) {
        return;
    }

    formulaire.style.display = 'none';
    affichage.style.display = 'block';
}
</script>

</body>

</html>