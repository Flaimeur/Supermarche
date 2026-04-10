# Fiche Projet : Supermarché 2.0

## 1. Présentation Générale
L'application **Supermarché 2.0** est une plateforme web développée pour gérer les opérations d'un supermarché. Elle permet d'un côté aux clients de s'inscrire, se connecter, consulter des produits et passer des commandes ; de l'autre, elle offre une interface d'administration pour gérer les produits et les comptes clients dans la base de données.

## 2. Fonctionnalités Principales

### 👨‍💼 Espace Client
*   **Animation d'accueil dynamique :** "Splash-screen" personnalisé au lancement de l'application.
*   **Inscription & Carte de Fidélité :** Création d'un nouveau compte client.
*   **Authentification :** Connexion sécurisée avec un système de session (`login.php`, `logout.php`).
*   **Commandes :** Possibilité de sélectionner des produits (`produits.php`), choisir les quantités (`quantite.php`), et de valider une commande (`Passer_commande.php`).
*   **Facturation :** Génération d'une facture récapitulative de la commande (`facture.php`).

### 🛠 Espace Administrateur (Gestion BD)
*   *L'accès à ces pages est réservé aux comptes ayant le statut administrateur (`EstAdmin == 1`).*
*   **Tableau de bord administrateur :** Vue d'ensemble pour la gestion globale (`admin_gestion.php`).
*   **Gestion des Produits :** Ajouter, modifier, et gérer le catalogue des articles vendus (`admin_produits.php`, `add_produit.php`, `edit_produit.php`).
*   **Gestion des Clients :** Modification et supervision des profils des utilisateurs inscrits (`edit_client.php`).

## 3. Technologies Utilisées
*   **Front-end :** HTML5, CSS3 (Feuille de style `style.css`), JavaScript (animations du DOM).
*   **Back-end :** PHP (gestions des entités, sessions et logique métier).
*   **Base de Données :** SQL (Dossier `SQL` contenant potentiellement les scripts de création et d'insertion).

---

## 4. Captures d'écran (À intégrer)

> *Note : N'ayant pas accès à l'affichage de votre navigateur en temps réel pour prendre des captures d'écran, **je vous ai préparé des emplacements ci-dessous**. 
Pour ajouter vos images, prenez vos captures, placez-les dans le dossier `img/` (ou un dossier `captures/`) et remplacez les textes entre crochets par le bon nom de fichier.*

### 1. Page d'Accueil (Animation & Menu de navigation)
*(Prenez une capture de la page `index.php` montrant l'écran de bienvenue et les boutons "Se connecter", "S'inscrire", etc.)*
![Capture Page d'Accueil](chemin/vers/votre/capture_accueil.png)

### 2. Page de Connexion / Inscription
*(Prenez une capture du formulaire de login ou d'enregistrement sur `login.php` ou `inscription.php`)*
![Capture Connexion](chemin/vers/votre/capture_connexion.png)

### 3. Interface de Prise de Commande
*(Prenez une capture de l'interface où le client choisit les produits et les quantités (`Passer_commande.php`)*
![Capture Prise de Commande](chemin/vers/votre/capture_commande.png)

### 4. Interface d'Administration (Gestion des Produits/Clients)
*(Prenez une capture depuis le compte d'un administrateur, par exemple sur l'écran `admin_gestion.php` ou `admin_produits.php`)*
![Capture Interface Administrateur](chemin/vers/votre/capture_admin.png)

### 5. Exemple de Facture Générée
*(Prenez une capture du rendu visuel de la page `facture.php` après une commande)*
![Capture Facture](chemin/vers/votre/capture_facture.png)
