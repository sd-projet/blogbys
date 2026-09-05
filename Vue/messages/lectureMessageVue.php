<!DOCTYPE html>
<html lang="fr">

<head>

    <title>Conversation</title>

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

                                <a href="../../Controleur/messages/reception.php">
                                    Messages
                                </a>

                            </li>

                            <li class="breadcrumb-item">

                                <a href="#!">
                                    Conversation
                                </a>

                            </li>

                        </ul>

                    </div>

                </div>

            </div>

        </div>


        <!-- Conversation -->

        <div class="conversation-page">

            <?php if (!$message): ?>


                <!-- Erreur -->

                <div class="conversation-error">

                    <div class="conversation-error-icon">

                        <i class="feather icon-alert-circle"></i>

                    </div>

                    <h3>
                        Impossible d'ouvrir la conversation
                    </h3>

                    <p>
                        <?= htmlspecialchars(
                            $erreur,
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>
                    </p>

                    <a
                        href="../../Controleur/messages/reception.php"
                        class="conversation-back-button"
                    >

                        <i class="feather icon-arrow-left"></i>

                        Retour aux messages

                    </a>

                </div>


            <?php else: ?>


                <!-- En-tête conversation -->

                <div class="conversation-header">

                    <div class="conversation-header-left">

                        <a
                            href="../../Controleur/messages/reception.php"
                            class="conversation-back"
                            title="Retour aux messages"
                        >

                            <i class="feather icon-arrow-left"></i>

                        </a>


                        <div class="conversation-avatar">

                            <?= htmlspecialchars(
                                strtoupper(
                                    mb_substr(
                                        $expediteur['pseudo'],
                                        0,
                                        1
                                    )
                                ),
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>

                        </div>


                        <div>

                            <h2>

                                <?= htmlspecialchars(
                                    $expediteur['pseudo'],
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>

                            </h2>

                            <span>

                                <?= count($conversation) ?>

                                message<?= count($conversation) > 1 ? 's' : '' ?>

                            </span>

                        </div>

                    </div>

                </div>


                <!-- Zone des messages -->

                <div
                    class="conversation-box"
                    id="conversation"
                >

                    <?php if (empty($conversation)): ?>

                        <div class="conversation-empty">

                            <div class="conversation-empty-icon">

                                <i class="feather icon-message-circle"></i>

                            </div>

                            <p>
                                Aucun message dans cette conversation.
                            </p>

                        </div>

                    <?php else: ?>


                        <?php foreach ($conversation as $msg): ?>

                            <?php

                            $estMoi = (
                                (int) $msg['id_expediteur']
                                === (int) $_SESSION['id']
                            );

                            ?>

                            <div
                                class="message-row <?= $estMoi ? 'message-sent' : 'message-received' ?>"
                            >


                                <?php if (!$estMoi): ?>

                                    <div class="message-avatar">

                                        <?= htmlspecialchars(
                                            strtoupper(
                                                mb_substr(
                                                    $msg['pseudo_expediteur'],
                                                    0,
                                                    1
                                                )
                                            ),
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ) ?>

                                    </div>

                                <?php endif; ?>


                                <div class="message-wrapper">


                                    <?php if (!$estMoi): ?>

                                        <span class="message-author">

                                            <?= htmlspecialchars(
                                                $msg['pseudo_expediteur'],
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ) ?>

                                        </span>

                                    <?php endif; ?>


                                    <div class="message-line">

                                        <div class="message-bubble">

                                            <?= nl2br(
                                                htmlspecialchars(
                                                    $msg['message'],
                                                    ENT_QUOTES,
                                                    'UTF-8'
                                                )
                                            ) ?>

                                        </div>


                                        <!-- Options -->

                                        <div class="dropdown message-options">

                                            <button
                                                type="button"
                                                class="message-options-button"
                                                data-toggle="dropdown"
                                                aria-haspopup="true"
                                                aria-expanded="false"
                                                title="Options"
                                            >

                                                <i class="feather icon-more-vertical"></i>

                                            </button>


                                            <div
                                                class="dropdown-menu <?= $estMoi ? 'dropdown-menu-right' : '' ?>"
                                            >

                                                <form
                                                    method="POST"
                                                    action="../../Controleur/messages/supprimer.php"
                                                    onsubmit="return confirm('Supprimer ce message uniquement pour vous ?');"
                                                >

                                                    <input
                                                        type="hidden"
                                                        name="id"
                                                        value="<?= (int) $msg['id_message'] ?>"
                                                    >

                                                    <input
                                                        type="hidden"
                                                        name="action"
                                                        value="me"
                                                    >

                                                    <input
                                                        type="hidden"
                                                        name="csrf_token"
                                                        value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                                                    >

                                                    <button
                                                        type="submit"
                                                        class="dropdown-item text-danger"
                                                    >
                                                        <i class="feather icon-trash-2 mr-2"></i>

                                                        Supprimer pour moi
                                                    </button>

                                                </form>


                                                <?php if ($estMoi): ?>

                                                    <form
                                                        method="POST"
                                                        action="../../Controleur/messages/supprimer.php"
                                                        onsubmit="return confirm('Supprimer ce message pour tout le monde ?');"
                                                    >

                                                        <input
                                                            type="hidden"
                                                            name="id"
                                                            value="<?= (int) $msg['id_message'] ?>"
                                                        >

                                                        <input
                                                            type="hidden"
                                                            name="action"
                                                            value="everyone"
                                                        >

                                                        <input
                                                            type="hidden"
                                                            name="csrf_token"
                                                            value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                                                        >

                                                        <button
                                                            type="submit"
                                                            class="dropdown-item text-danger"
                                                        >
                                                            <i class="feather icon-trash-2 mr-2"></i>

                                                            Supprimer pour tout le monde
                                                        </button>

                                                    </form>

                                                <?php endif; ?>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        <?php endforeach; ?>


                    <?php endif; ?>

                </div>


                <!-- Réponse -->

                <div class="conversation-reply">

                    <form
                        action="../../Controleur/messages/envoiMessage.php"
                        method="post"
                    >

                        <input
                            type="hidden"
                            name="id_destinataire"
                            value="<?= (int) $expediteur['id'] ?>"
                        >


                        <div class="reply-input">

                            <textarea
                                name="message"
                                rows="1"
                                placeholder="Écrire un message..."
                                required
                            ></textarea>


                            <button
                                type="submit"
                                name="envoi_message"
                                class="reply-send"
                                title="Envoyer"
                            >

                                <i class="feather icon-navigation"></i>

                            </button>

                        </div>

                    </form>

                </div>


            <?php endif; ?>

        </div>

    </div>

</div>


<!-- Scripts -->

<script src="../../assets/js/vendor-all.min.js"></script>
<script src="../../assets/js/plugins/bootstrap.min.js"></script>
<script src="../../assets/js/pcoded.min.js"></script>
<script src="https://unpkg.com/feather-icons"></script>


<script>

const conversation = document.getElementById('conversation');

if (conversation) {

    conversation.scrollTop = conversation.scrollHeight;

}

</script>

</body>

</html>