<?php

$host = getenv('DB_HOST') ?: 'localhost';
$port = getenv('DB_PORT') ?: '3306';
$login = getenv('DB_USERNAME') ?: 'root';
$password = getenv('DB_PASSWORD') ?: '';
$dbname = getenv('DB_DATABASE') ?: 'projet-php';

/*
 * Configuration PDO commune
 */
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
];

/*
 * Connexion locale : XAMPP / MariaDB
 */
if ($host === 'localhost') {

    $bdd = new PDO(
        "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4",
        $login,
        $password,
        $options
    );

} else {

    /*
     * Production : TiDB Cloud avec TLS
     */
    $caPath = __DIR__ . '/certs/isrgrootx1.pem';

    if (!file_exists($caPath)) {
        throw new RuntimeException(
            'Certificat SSL introuvable : ' . $caPath
        );
    }

    $options[PDO::MYSQL_ATTR_SSL_CA] = $caPath;
    $options[PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT] = true;

    $bdd = new PDO(
        "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4",
        $login,
        $password,
        $options
    );
}
?>
