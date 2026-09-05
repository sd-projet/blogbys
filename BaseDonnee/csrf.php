<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/*
 * Création du token CSRF
 */
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(
        random_bytes(32)
    );
}

/*
 * Vérification du token CSRF
 */
function verifierCSRF($token)
{
    return isset($_SESSION['csrf_token']) &&
           is_string($token) &&
           hash_equals($_SESSION['csrf_token'], $token);
}