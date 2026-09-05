<?php

session_start();

require("../../BaseDonnee/connect.php");

$bdd = new PDO(
    "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
    $login,
    $password,
    [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]
);

/*
 * Vérification de la connexion
 */
if (!isset($_SESSION['id']) || empty($_SESSION['id'])) {
    header('Location: ../compte/connexionControleur.php');
    exit;
}

$id_utilisateur = (int) $_SESSION['id'];

$mode_edition = false;
$edit_publication = null;
$edit_id = null;
$message = null;


/*
 * =========================
 * MODE MODIFICATION
 * =========================
 */

if (
    isset($_GET['edit']) &&
    ctype_digit($_GET['edit'])
) {

    $mode_edition = true;
    $edit_id = (int) $_GET['edit'];

    $requetePublication = $bdd->prepare(
        'SELECT *
         FROM publications
         WHERE id_photo = ?
         AND id_memb = ?'
    );

    $requetePublication->execute([
        $edit_id,
        $id_utilisateur
    ]);

    $edit_publication = $requetePublication->fetch();

    /*
     * La publication n'existe pas
     * ou n'appartient pas à l'utilisateur
     */
    if (!$edit_publication) {
        header('Location: publication.php');
        exit;
    }
}


/*
 * =========================
 * AJOUT / MODIFICATION
 * =========================
 */

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $publication_titre = trim(
        $_POST['publication_titre'] ?? ''
    );

    $publication_contenu = trim(
        $_POST['publication_contenu'] ?? ''
    );


    /*
     * Vérification des champs
     */

    if (
        $publication_titre === '' ||
        $publication_contenu === ''
    ) {

        $message = "Veuillez remplir tous les champs.";

    } else {


        /*
         * =========================
         * CREATION
         * =========================
         */

        if (!$mode_edition) {


            /*
             * Vérification de la présence
             * d'une image
             */

            if (
                !isset($_FILES['miniature']) ||
                $_FILES['miniature']['error'] === UPLOAD_ERR_NO_FILE
            ) {

                $message = "Veuillez sélectionner une image.";

            } else {

                $fichier = $_FILES['miniature'];


                /*
                 * Vérification de l'upload
                 */

                if ($fichier['error'] !== UPLOAD_ERR_OK) {

                    $message =
                        "Une erreur est survenue lors de l'envoi de l'image.";


                /*
                 * Taille maximale : 5 Mo
                 */

                } elseif (
                    $fichier['size'] > 5 * 1024 * 1024
                ) {

                    $message =
                        "L'image ne doit pas dépasser 5 Mo.";


                } else {


                    /*
                     * Vérification du véritable
                     * type MIME
                     */

                    $finfo = finfo_open(
                        FILEINFO_MIME_TYPE
                    );

                    $mime = finfo_file(
                        $finfo,
                        $fichier['tmp_name']
                    );

                    finfo_close($finfo);


                    /*
                     * Seules les images JPEG
                     * sont acceptées
                     */

                    if ($mime !== 'image/jpeg') {

                        $message =
                            "Le fichier doit être une image JPEG.";

                    } else {


                        /*
                         * Création de la publication
                         * uniquement après validation
                         * complète de l'image.
                         */

                        $ins = $bdd->prepare(
                            'INSERT INTO publications
                            (
                                titre,
                                contenu,
                                date_time_publication,
                                id_memb
                            )
                            VALUES (?, ?, NOW(), ?)'
                        );

                        $ins->execute([
                            $publication_titre,
                            $publication_contenu,
                            $id_utilisateur
                        ]);


                        /*
                         * Récupération de l'ID
                         * de la publication créée
                         */

                        $lastid = (int) $bdd->lastInsertId();


                        /*
                         * Enregistrement de l'image
                         */

                        $destination =
                            __DIR__ .
                            '/../../miniatures/' .
                            $lastid .
                            '.jpg';
                        if (
                            move_uploaded_file(
                                $fichier['tmp_name'],
                                $destination
                            )
                        ) {


                            /*
                             * Publication créée
                             * avec succès
                             */

                            header(
                                'Location: publication.php'
                            );

                            exit;


                        } else {


                            /*
                             * L'image n'a pas pu être
                             * enregistrée.
                             *
                             * On supprime donc la publication
                             * créée afin d'éviter une publication
                             * sans image.
                             */

                            $suppression = $bdd->prepare(
                                'DELETE FROM publications
                                 WHERE id_photo = ?
                                 AND id_memb = ?'
                            );

                            $suppression->execute([
                                $lastid,
                                $id_utilisateur
                            ]);

                            $message =
                                "Impossible d'enregistrer l'image.";
                        }
                    }
                }
            }


        /*

        * =========================
        * MODIFICATION
        * =========================
        */

        } else {


            /*
            * Vérification d'une éventuelle
            * nouvelle image avant la modification
            */

            $nouvelle_image = false;

            if (
                isset($_FILES['miniature']) &&
                $_FILES['miniature']['error'] !== UPLOAD_ERR_NO_FILE
            ) {

                $fichier = $_FILES['miniature'];

                /*
                * Vérification de l'upload
                */
                if ($fichier['error'] !== UPLOAD_ERR_OK) {

                    $message =
                        "Une erreur est survenue lors de l'envoi de l'image.";

                /*
                * Taille maximale : 5 Mo
                */
                } elseif ($fichier['size'] > 5 * 1024 * 1024) {

                    $message =
                        "L'image ne doit pas dépasser 5 Mo.";

                } else {

                    /*
                    * Vérification du véritable type MIME
                    */
                    $finfo = finfo_open(FILEINFO_MIME_TYPE);

                    $mime = finfo_file(
                        $finfo,
                        $fichier['tmp_name']
                    );

                    finfo_close($finfo);


                    if ($mime !== 'image/jpeg') {

                        $message =
                            "Le fichier doit être une image JPEG.";

                    } else {

                        $nouvelle_image = true;
                    }
                }
            }


            /*
            * On continue uniquement si
            * aucune erreur n'a été détectée
            */

            if ($message === null) {
                /*
                * Remplacement de l'image
                * uniquement si une nouvelle
                * image a été sélectionnée
                */

                if ($nouvelle_image) {

                    $destination =
                        __DIR__ .
                        '/../../miniatures/' .
                        $edit_id .
                        '.jpg';

                    if (
                        move_uploaded_file(
                            $fichier['tmp_name'],
                            $destination
                        )
                    ) {

                        $update = $bdd->prepare(
                            'UPDATE publications
                            SET titre = ?,
                                contenu = ?,
                                date_time_edition = NOW()
                            WHERE id_photo = ?
                            AND id_memb = ?'
                        );

                        $update->execute([
                            $publication_titre,
                            $publication_contenu,
                            $edit_id,
                            $id_utilisateur
                        ]);

                        header('Location: publication.php');
                        exit;

                    } else {

                        $message = "Impossible de remplacer l'image.";
                    }

                } else {

                    $update = $bdd->prepare(
                        'UPDATE publications
                        SET titre = ?,
                            contenu = ?,
                            date_time_edition = NOW()
                        WHERE id_photo = ?
                        AND id_memb = ?'
                    );

                    $update->execute([
                        $publication_titre,
                        $publication_contenu,
                        $edit_id,
                        $id_utilisateur
                    ]);

                    header('Location: publication.php');
                    exit;
                }
            }


        }

    }
}


/*
 * =========================
 * AFFICHAGE DU FORMULAIRE
 * =========================
 */

require(
    "../../Vue/publications/redaction.php"
);
?>
