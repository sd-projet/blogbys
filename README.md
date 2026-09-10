# BlogByS

> Application web de type réseau social permettant aux utilisateurs de créer un compte, publier du contenu et interagir avec la communauté.

🔗 **Démo en ligne :** URL Render

---

## 🚀 À propos du projet

**BlogByS** est une application web full-stack développée en PHP permettant aux utilisateurs de créer un compte, publier du contenu et interagir avec les autres membres.

Ce projet m'a permis de travailler sur l'ensemble du cycle de développement d'une application web : conception de la base de données, développement backend, gestion des utilisateurs, interactions sociales, sécurisation des formulaires et déploiement d'une application en production.

L'objectif était de développer une application complète en mettant l'accent sur la **logique métier**, la **gestion des données** et l'**expérience utilisateur**.

---

## ✨ Fonctionnalités

### 👤 Gestion des utilisateurs

* Création de compte et authentification
* Gestion des sessions utilisateur
* Consultation et modification du profil
* Déconnexion sécurisée

### 📝 Publications

* Création de publications avec image
* Modification et suppression des publications
* Gestion des images uploadées
* Affichage d'un fil d'actualité

### 💬 Interactions sociales

* Système de commentaires
* Modification et suppression des commentaires
* Système de likes
* Affichage du nombre de likes
* Gestion de l'état du like pour l'utilisateur connecté

### ✉️ Messagerie

* Envoi de messages entre utilisateurs
* Consultation des conversations
* Gestion des messages lus / non lus
* Suppression de messages

---

## 🛠️ Stack technique

### Backend

* PHP
* PDO
* Architecture MVC
* Sessions PHP
* MySQL / TiDB Cloud

### Base de données

* Modélisation et gestion d'une base de données relationnelle
* Requêtes SQL complexes
* Jointures
* Agrégations (`COUNT`, `MAX`, `CASE`)
* Requêtes préparées avec PDO

### Frontend

* HTML
* CSS
* JavaScript
* TinyButStrong
* VueJS

### Déploiement & Infrastructure

* Docker
* Apache
* Render
* TiDB Cloud
* Git
* GitHub

---

## 🔐 Sécurité

Plusieurs bonnes pratiques ont été mises en place dans le projet :

* Utilisation de requêtes préparées avec PDO
* Protection contre les injections SQL
* Gestion des sessions utilisateur
* Validation des données côté serveur
* Vérification des fichiers uploadés
* Vérification du type MIME des images
* Limitation de la taille des fichiers
* Protection CSRF
* Connexion sécurisée à la base de données en production via TLS

Les informations sensibles de connexion à la base de données sont gérées à l'aide de variables d'environnement et ne sont pas présentes dans le dépôt.

---

## 🏗️ Architecture

Le projet suit une organisation inspirée de l'architecture **MVC** :

```text
ProjetPHP/
│
├── BaseDonnee/
│   ├── connect.php
│   ├── csrf.php
│   └── certs/
│
├── Controleur/
│   ├── compte/
│   ├── messages/
│   └── publications/
│
├── Vue/
│   ├── compte/
│   ├── messages/
│   └── publications/
│
├── miniatures/
│
├── tbs_3132/
│
├── Dockerfile
├── .dockerignore
└── .gitignore
```

Cette organisation permet de séparer la logique applicative, l'accès aux données et les vues.

---

## ☁️ Déploiement

L'application est conteneurisée avec **Docker** puis déployée sur **Render**.

La base de données est hébergée sur **TiDB Cloud**, avec une connexion sécurisée via TLS.

Les paramètres de connexion sont configurés à l'aide de variables d'environnement :

```env
DB_HOST=
DB_PORT=
DB_USERNAME=
DB_PASSWORD=
DB_DATABASE=
```

---

## 💡 Compétences mises en œuvre

Ce projet met notamment en pratique :

* Développement d'une application web full-stack
* Développement backend en PHP
* Conception et exploitation d'une base de données relationnelle
* Écriture et optimisation de requêtes SQL
* Architecture MVC
* Authentification et gestion des sessions
* Gestion d'uploads de fichiers
* Développement de fonctionnalités sociales
* Sécurisation d'une application web
* Utilisation d'API et de services cloud
* Gestion des variables d'environnement
* Conteneurisation avec Docker
* Déploiement d'une application web
* Gestion de version avec Git et GitHub

---


## 👩‍💻 Développé par

**Senebou Diarra**

Développeuse Full-Stack
