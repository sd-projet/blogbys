<?php

function getNombreMessagesNonLus(PDO $bdd, int $id_utilisateur): int
{
    $requete = $bdd->prepare(
        'SELECT COUNT(*) AS nombre
         FROM messages
         WHERE id_destinataire = ?
         AND lu = 0
         AND supprime_par_destinataire = 0'
    );

    $requete->execute([$id_utilisateur]);

    return (int) $requete->fetch()['nombre'];
}