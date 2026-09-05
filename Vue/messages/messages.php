<!DOCTYPE html>
<html lang="fr">

<head>

    <title>Messages</title>

    <meta charset="utf-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui"
    >

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
        href="../../assets/css/messages.css"
    >

</head>

<body>

<?php require_once(__DIR__ . '/../composants/menu.php'); ?>


<!-- Header -->

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


<!-- Contenu principal -->

<div class="pcoded-main-container">

    <div class="pcoded-content">


        <!-- Breadcrumb -->

        <div class="page-header">

            <div class="page-block">

                <div class="row align-items-center">

                    <div class="col-md-12">

                        <div class="page-header-title">

                            <h5 class="m-b-10">
                                Messages
                            </h5>

                        </div>

                        <ul class="breadcrumb">

                            <li class="breadcrumb-item">

                                <a href="../../Controleur/compte/profil.php">

                                    <i class="feather icon-home"></i>

                                </a>

                            </li>

                            <li class="breadcrumb-item">

                                <a href="#!">
                                    Messages
                                </a>

                            </li>

                        </ul>

                    </div>

                </div>

            </div>

        </div>


        <!-- Page Messages -->

        <div class="messages-page">


            <!-- En-tête -->

            <div class="messages-header">

                <div>

                    <h2>
                        Mes messages
                    </h2>

                    <p>
                        Consultez vos conversations ou envoyez un nouveau message.
                    </p>

                </div>

                <?php if ($nombreNonLus > 0): ?>

                    <div class="messages-unread">

                        <i class="feather icon-mail"></i>

                        <?= $nombreNonLus ?>

                        message<?= $nombreNonLus > 1 ? 's' : '' ?>
                        non lu<?= $nombreNonLus > 1 ? 's' : '' ?>

                    </div>

                <?php endif; ?>

            </div>


            <!-- Navigation -->

            <div class="messages-tabs">

                <button
                    type="button"
                    class="messages-tab <?= $erreur !== null ? '' : 'active' ?>"
                    data-target="messages-reception"
                >

                    <i class="feather icon-inbox"></i>

                    Boîte de réception

                    <?php if ($nombreNonLus > 0): ?>

                        <span class="messages-tab-count">
                            <?= $nombreNonLus ?>
                        </span>

                    <?php endif; ?>

                </button>


                <button
                    type="button"
                    class="messages-tab <?= $erreur !== null ? 'active' : '' ?>"
                    data-target="messages-nouveau"
                >

                    <i class="feather icon-edit-2"></i>

                    Nouveau message

                </button>

            </div>


            <!-- Contenu -->

            <div class="messages-content">


                <!-- Erreur -->

                <?php if ($erreur !== null): ?>

                    <div class="messages-alert">

                        <i class="feather icon-alert-circle"></i>

                        <span>
                            <?= htmlspecialchars(
                                $erreur,
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>
                        </span>

                    </div>

                <?php endif; ?>


                <!-- Boîte de réception -->

                <div
                    id="messages-reception"
                    class="messages-panel <?= $erreur !== null ? '' : 'active' ?>"
                >

                    <?php if (empty($messages)): ?>

                        <div class="messages-empty">

                            <div class="messages-empty-icon">

                                <i class="feather icon-mail"></i>

                            </div>

                            <h3>
                                Aucun message
                            </h3>

                            <p>
                                Vous n'avez encore aucune conversation.
                            </p>

                        </div>

                    <?php else: ?>

                        <div class="conversation-list">

                            <?php foreach ($messages as $message): ?>

                                <?php

                                $nonLu = (
                                    (int) $message['lu'] === 0 &&
                                    (int) $message['id_expediteur'] !== $id_utilisateur
                                );

                                $pseudo = $message['pseudo_correspondant'];

                                $initiale = strtoupper(
                                    mb_substr($pseudo, 0, 1)
                                );

                                ?>

                                <a
                                    href="../../Controleur/messages/lectureMessageControleur.php?id=<?= (int) $message['id_correspondant'] ?>"
                                    class="conversation-card <?= $nonLu ? 'unread' : '' ?>"
                                >

                                    <!-- Avatar -->

                                    <div class="conversation-avatar">

                                        <?= htmlspecialchars(
                                            $initiale,
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ) ?>

                                    </div>


                                    <!-- Informations -->

                                    <div class="conversation-content">

                                        <div class="conversation-top">

                                            <strong class="conversation-name">

                                                <?= htmlspecialchars(
                                                    $pseudo,
                                                    ENT_QUOTES,
                                                    'UTF-8'
                                                ) ?>

                                            </strong>


                                            <?php if ($nonLu): ?>

                                                <span class="conversation-badge">
                                                    Nouveau
                                                </span>

                                            <?php endif; ?>

                                        </div>


                                        <p class="conversation-preview">

                                            <?php if (
                                                (int) $message['id_expediteur'] === $id_utilisateur
                                            ): ?>

                                                <strong>
                                                    Vous :
                                                </strong>

                                            <?php endif; ?>

                                            <?= htmlspecialchars(
                                                $message['message'],
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ) ?>

                                        </p>

                                    </div>


                                    <!-- Flèche -->

                                    <div class="conversation-arrow">

                                        <i class="feather icon-chevron-right"></i>

                                    </div>

                                </a>

                            <?php endforeach; ?>

                        </div>

                    <?php endif; ?>

                </div>


                <!-- Nouveau message -->

                <div
                    id="messages-nouveau"
                    class="messages-panel <?= $erreur !== null ? 'active' : '' ?>"
                >

                    <div class="new-message-card">

                        <div class="new-message-header">

                            <div class="new-message-icon">
                                <i class="feather icon-navigation"></i>
                            </div>

                            <div>

                                <h3>
                                    Nouveau message
                                </h3>

                                <p>
                                    Envoyez un message à un autre membre.
                                </p>

                            </div>

                        </div>


                        <form
                            action="../../Controleur/messages/envoiMessage.php"
                            method="post"
                            class="new-message-form"
                        >

                            <div class="form-group">

                                <label for="destinataire">
                                    Destinataire
                                </label>

                                <div class="message-input-wrapper">

                                    <i class="feather icon-user"></i>

                                    <input
                                        type="text"
                                        name="destinataire"
                                        id="destinataire"
                                        placeholder="Pseudo du destinataire"
                                        required
                                    >

                                </div>

                            </div>


                            <div class="form-group">

                                <label for="message">
                                    Message
                                </label>

                                <textarea
                                    name="message"
                                    id="message"
                                    rows="6"
                                    placeholder="Écrivez votre message..."
                                    required
                                ></textarea>

                            </div>


                            <div class="new-message-actions">

                                <button
                                    type="submit"
                                    name="envoi_message"
                                    class="send-message-button"
                                >

                                    <i class="feather icon-navigation"></i>

                                    Envoyer

                                </button>

                            </div>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>


<!-- Scripts -->

<script src="../../assets/js/vendor-all.min.js"></script>

<script src="../../assets/js/plugins/bootstrap.min.js"></script>

<script src="../../assets/js/pcoded.min.js"></script>


<script>

document.querySelectorAll('.messages-tab').forEach(function (tab) {

    tab.addEventListener('click', function () {

        const target = this.dataset.target;

        document.querySelectorAll('.messages-tab').forEach(function (item) {
            item.classList.remove('active');
        });

        document.querySelectorAll('.messages-panel').forEach(function (panel) {
            panel.classList.remove('active');
        });

        this.classList.add('active');

        const panel = document.getElementById(target);

        if (panel) {
            panel.classList.add('active');
        }

    });

});

</script>

</body>

</html>