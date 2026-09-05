<?php
session_start();

require("../BaseDonnee/connect.php");
require("../tbs_3132/tbs_class.php");

$tbs = new clsTinyButStrong;

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
 * Récupération des publications
 */
$id_utilisateur = isset($_SESSION['id'])
    ? (int) $_SESSION['id']
    : 0;

$utilisateur_connecte = isset($_SESSION['id']) && !empty($_SESSION['id'])
    ? 1
    : 0;

$requete = $bdd->prepare(
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
    GROUP BY publications.id_photo
    ORDER BY publications.date_time_publication DESC"
);

$requete->execute([$id_utilisateur]);

$articles = $requete->fetchAll();

foreach ($articles as &$article) {
    $article['utilisateur_connecte'] = $utilisateur_connecte;
    $article['classe_like'] = !empty($article['utilisateur_aime'])
    ? 'liked'
    : '';
}
unset($article);


$nombrePublications = count($articles);

foreach ($articles as &$article) {
    $article['date_formatee'] = date(
        'd/m/Y à H:i',
        strtotime($article['date_time_publication'])
    );
}
unset($article);


if ($utilisateur_connecte) {
    $menu = '
        <a href="../Controleur/compte/profil.php">
            Mon profil
        </a>

        <a href="../Controleur/messages/reception.php">
            Messages
        </a>

        <a href="../Controleur/compte/deconnexion.php">
            Déconnexion
        </a>
    ';
} else {
    $menu = '
        <a href="../Controleur/compte/connexionControleur.php">
            Me connecter
        </a>

        <a
            href="../Controleur/compte/inscriControleur.php"
            class="register"
        >
            M\'inscrire
        </a>
    ';
}

$tbs->MergeField("menu", $menu);
$tbs->MergeField("utilisateur_connecte", $utilisateur_connecte);


/*
 * Chargement de la vue
 */
$tbs->LoadTemplate("../Vue/accueil.php");

/*
 * Transmission des publications à TinyButStrong
 */
$tbs->MergeBlock("articles", $articles);


/*
 * Affichage
 */
$tbs->Show();

?>