<!DOCTYPE html>
<html lang="fr">

    <head>
        <title>Mes publications</title>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
        <!-- Meta -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="description" content="" />
        <meta name="keywords" content="">
        <!-- Favicon icon -->
        <link rel="icon" href="../../assets/images/favicon.ico" type="image/x-icon">
        <!-- vendor css -->
        <link rel="stylesheet" href="../../assets/css/style.css">

    </head>
    <body class="">

    <?php require_once(__DIR__ . '/../composants/menu.php'); ?>

    <!-- [ navigation menu ] end -->
    <!-- [ Header ] start -->
    <header class="navbar pcoded-header navbar-expand-lg navbar-light header-dark">
        <div class="m-header">
            <a class="mobile-menu" id="mobile-collapse" href="#!"><span></span></a>
            <a href="#!" class="b-brand">
                <!-- ========   change your logo hear   ============ -->
                <img src="../../assets/images/logo.png" alt="" class="logo">
                <img src="../assets/images/logo-icon.png" alt="" class="logo-thumb">
            </a>
            <a href="#!" class="mob-toggler">
                <i class="feather icon-more-vertical"></i>
            </a>
        </div>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ml-auto">
                <li>
                    <div class="dropdown drp-user">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="feather icon-user"></i>
                        </a>
                    </div>
                </li>
            </ul>
        </div>
    </header>
    <!-- [ Header ] end -->
    <!-- [ Main Content ] start -->
    <div class="pcoded-main-container">
        <div class="pcoded-content">
            <!-- [ breadcrumb ] start -->
            <div class="page-header">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h5 class="m-b-10">Profil</h5>
                            </div>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="../../Controleur/compte/profil.php"><i class="feather icon-home"></i></a></li>
                                <li class="breadcrumb-item"><a href="../../Controleur/publications/publication.php">Publications</a></li>
                                <li class="breadcrumb-item"><a href="../../Controleur/publications/publication.php">Mes publications</a></li>
                                <li class="breadcrumb-item"><a href="#!">Ajouter une publication</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class=" col-md-12">
                <div class="card latest-update-card">
                    <div class="card-body">
                        <br>
                        <h1 class="mt-4">
                            <?= $mode_edition ? 'Modifier la publication' : 'Ajouter une publication' ?>
                        </h1>
                        <hr>
                        <form method="POST" enctype="multipart/form-data">
                            <div class="col-xl-12">
                                <div class="col-md-8 mb-3">
                                    <label >Titre</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="validationCustom01"
                                        name="publication_titre"
                                        value="<?= $mode_edition ? htmlspecialchars($edit_publication['titre'], ENT_QUOTES, 'UTF-8') : '' ?>"
                                        required
                                    >
                                </div>
                                <div class="col-md-8 mb-3">
                                    <label>Description</label>
                                    <textarea
                                        class="form-control"
                                        rows="2"
                                        cols="20"
                                        name="publication_contenu"
                                        required
                                    ><?= $mode_edition ? htmlspecialchars($edit_publication['contenu'], ENT_QUOTES, 'UTF-8') : '' ?></textarea>
                                </div>

                                <div class="col-md-8">
                                    <h5 class="mt-3">
                                        <?= $mode_edition ? 'Image de la publication' : 'Choisir une image' ?>
                                    </h5>
                                    <hr>

                                    <?php if ($mode_edition && !empty($edit_publication['id_photo'])): ?>

                                        <div class="mb-3">
                                            <p>
                                                <strong>Image actuelle :</strong>
                                                <?= (int) $edit_publication['id_photo'] ?>.jpg
                                            </p>

                                            <img
                                                id="image-preview"
                                                src="../../miniatures/<?= (int) $edit_publication['id_photo'] ?>.jpg"
                                                alt="Image actuelle"
                                                style="max-width: 250px; max-height: 200px;"
                                                class="img-thumbnail"
                                            >
                                        </div>

                                        <p class="text-muted">
                                            Sélectionnez une nouvelle image uniquement si vous souhaitez la remplacer.
                                        </p>

                                    <?php endif; ?>

                                    <div class="custom-file">
                                        <input
                                            type="file"
                                            class="custom-file-input"
                                            name="miniature"
                                            accept="image/jpeg"
                                            id="inputGroupFile03"
                                            <?= !$mode_edition ? 'required' : '' ?>
                                        >

                                        <label class="custom-file-label" for="inputGroupFile03">
                                            <?= $mode_edition ? 'Choisir une nouvelle image' : 'Choisir une image' ?>
                                        </label>
                                    </div>
                                </div>
                                <br>
                                <div class="col-md-8 mb-3">
                                    <input
                                        class="btn btn-primary"
                                        type="submit"
                                        value="<?= $mode_edition ? 'Modifier' : 'Ajouter' ?>"
                                    />
                                    <a class="btn btn-secondary" href="../../Controleur/publications/publication.php">Annuler</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <![endif]-->
    <!-- Required Js -->
    <script src="../../assets/js/plugins/bootstrap.min.js"></script>
    <script src="../../assets/js/pcoded.min.js"></script>

    <script>
        const inputImage = document.getElementById('inputGroupFile03');
        const imagePreview = document.getElementById('image-preview');

        if (inputImage && imagePreview) {

            inputImage.addEventListener('change', function () {

                const fichier = this.files[0];

                if (!fichier) {
                    return;
                }

                const lecteur = new FileReader();

                lecteur.onload = function (event) {

                    imagePreview.src = event.target.result;

                };

                lecteur.readAsDataURL(fichier);

            });

        }
    </script>
</body>

</html>
