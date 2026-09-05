-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : dim. 16 avr. 2023 à 19:30
-- Version du serveur : 10.4.22-MariaDB
-- Version de PHP : 8.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";
SET NAMES utf8mb4;

-- ============================================================
-- Table : membres
-- ============================================================

CREATE TABLE membres (
    id INT NOT NULL AUTO_INCREMENT,
    pseudo VARCHAR(255) NOT NULL,
    mail VARCHAR(255) NOT NULL,
    motdepasse VARCHAR(255) NOT NULL,
    PRIMARY KEY (id),
    UNIQUE KEY unique_pseudo (pseudo),
    UNIQUE KEY unique_mail (mail)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================
-- Table : publications
-- ============================================================

CREATE TABLE publications (
    id_photo INT NOT NULL AUTO_INCREMENT,
    titre VARCHAR(255) NOT NULL,
    contenu TEXT NOT NULL,
    date_time_publication DATETIME NOT NULL,
    date_time_edition DATETIME DEFAULT NULL,
    id_memb INT DEFAULT NULL,
    PRIMARY KEY (id_photo),
    INDEX idx_publications_membre (id_memb),
    CONSTRAINT publications_ibfk_1
        FOREIGN KEY (id_memb)
        REFERENCES membres(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================
-- Table : commentaires
-- ============================================================

CREATE TABLE commentaires (
    id_comm INT NOT NULL AUTO_INCREMENT,
    pseudo VARCHAR(255) NOT NULL,
    commentaire TEXT NOT NULL,
    id_publication INT NOT NULL,
    PRIMARY KEY (id_comm),
    INDEX idx_commentaires_publication (id_publication),
    CONSTRAINT commentaires_ibfk_1
        FOREIGN KEY (id_publication)
        REFERENCES publications(id_photo)
        ON DELETE CASCADE
        ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE commentaires
ADD COLUMN id_memb INT NOT NULL AFTER id_comm;

ALTER TABLE commentaires
ADD CONSTRAINT commentaires_ibfk_2
    FOREIGN KEY (id_memb)
    REFERENCES membres(id)
    ON DELETE CASCADE
    ON UPDATE CASCADE;
    
-- ============================================================
-- Table : messages
-- ============================================================

CREATE TABLE messages (
    id_message INT NOT NULL AUTO_INCREMENT,
    id_expediteur INT NOT NULL,
    id_destinataire INT NOT NULL,
    message TEXT NOT NULL,
    lu INT NOT NULL DEFAULT 0,
    objet TEXT NOT NULL,
    PRIMARY KEY (id_message),
    INDEX idx_messages_expediteur (id_expediteur),
    INDEX idx_messages_destinataire (id_destinataire),
    CONSTRAINT messages_ibfk_1
        FOREIGN KEY (id_expediteur)
        REFERENCES membres(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    CONSTRAINT messages_ibfk_2
        FOREIGN KEY (id_destinataire)
        REFERENCES membres(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE messages
MODIFY objet TEXT NULL;

ALTER TABLE messages
ADD COLUMN supprime_par_expediteur TINYINT(1) NOT NULL DEFAULT 0,
ADD COLUMN supprime_par_destinataire TINYINT(1) NOT NULL DEFAULT 0;

-- ============================================================
-- Table : likes
-- ============================================================

CREATE TABLE likes (
    id_like INT NOT NULL AUTO_INCREMENT,
    id_memb INT NOT NULL,
    id_publication INT NOT NULL,
    
    PRIMARY KEY (id_like),
    
    UNIQUE KEY unique_like (id_memb, id_publication),
    
    INDEX idx_likes_publication (id_publication),
    INDEX idx_likes_membre (id_memb),
    
    CONSTRAINT likes_ibfk_1
        FOREIGN KEY (id_memb)
        REFERENCES membres(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
        
    CONSTRAINT likes_ibfk_2
        FOREIGN KEY (id_publication)
        REFERENCES publications(id_photo)
        ON DELETE CASCADE
        ON UPDATE CASCADE
        
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

COMMIT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
