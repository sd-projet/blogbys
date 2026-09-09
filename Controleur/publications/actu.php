<?php

session_start();

require("../../BaseDonnee/connect.php");

$id_utilisateur = isset($_SESSION['id'])
    ? (int) $_SESSION['id']
    : 0;

/*$publications = $bdd->prepare(
    "SELECT 
        publications.*,
        membres.pseudo,
        COUNT(DISTINCT likes.id_like) AS nombre_likes,
        MAX(
            CASE 
                WHEN likes.id_memb = ? THEN 1
                ELSE 0
            END
        ) AS utilisateur_aime
    FROM publications
    INNER JOIN membres
        ON publications.id_memb = membres.id
    LEFT JOIN likes
        ON publications.id_photo = likes.id_publication
    WHERE publications.id_memb != ?
    GROUP BY publications.id_photo
    ORDER BY publications.date_time_publication DESC"
);

$publications->execute([
    $id_utilisateur,
    $id_utilisateur
]);*/

$publications = $bdd->prepare(
    "SELECT
        publications.*,
        membres.pseudo,
        COALESCE(stats.nombre_likes, 0) AS nombre_likes,
        COALESCE(stats.utilisateur_aime, 0) AS utilisateur_aime
    FROM publications
    INNER JOIN membres
        ON publications.id_memb = membres.id
    LEFT JOIN (
        SELECT
            id_publication,
            COUNT(DISTINCT id_like) AS nombre_likes,
            MAX(
                CASE
                    WHEN id_memb = ? THEN 1
                    ELSE 0
                END
            ) AS utilisateur_aime
        FROM likes
        GROUP BY id_publication
    ) AS stats
        ON publications.id_photo = stats.id_publication
    WHERE publications.id_memb != ?
    ORDER BY publications.date_time_publication DESC"
);

$publications->execute([
    $id_utilisateur,
    $id_utilisateur
]);

require("../../Vue/publications/fil_actu.php");