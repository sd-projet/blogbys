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

$id_utilisateur = isset($_SESSION['id'])
    ? (int) $_SESSION['id']
    : 0;

$publications = $bdd->prepare(
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
]);

require("../../Vue/publications/fil_actu.php");