# Fiche Projet : Supermarché 2.0

## 1. Présentation Générale
L'application **Supermarché 2.0** est une plateforme web développée pour gérer les opérations d'un supermarché. Elle permet d'un côté aux clients de s'inscrire, se connecter, consulter des produits et passer des commandes ; de l'autre, elle offre une interface d'administration pour gérer les produits et les comptes clients dans la base de données.

## 2. Fonctionnalités Principales

### 👨‍💼 Espace Client
*   **Animation d'accueil dynamique :** "Splash-screen" pro-grade au lancement de l'application.
*   **Routeur Centralisé :** Toute la navigation passe par `index.php?action=...` pour une sécurité accrue.
*   **Authentification :** Connexion et déconnexion via `ControllerAuth`.
*   **Catalogue & Commandes :** Navigation par rayons, choix des quantités et panier géré par `ControllerCatalog`.
*   **Facturation :** Génération d'une facture récapitulative dynamique.

### 🛠 Espace Administrateur (Gestion BD)
*   *L'accès est réservé aux comptes avec un `role` administratif.*
*   **Gestion des Membres :** Supervision complète des adhérents via `ControllerAdmin`.
*   **Gestion du Catalogue :** Ajout, modification et suppression des produits via une interface sécurisée.
*   **Sécurité RBAC :** Les droits sont modulés selon la fonction (admin_produits, admin_comptes, etc.).

## 3. Technologies Utilisées
*   **Architecture :** MVC (Modèle-Vue-Contrôleur) complet.
*   **Backend :** PHP 8, Sessions, Router, PDO.
*   **Frontend :** Design System moderne, CSS Variable, Glassmorphism.

---

## 4. Captures d'écran (À intégrer)

### 1. Page d'Accueil (Dashboard MVC)
*(Capture du dashboard après l'animation splash)*
![Capture Page d'Accueil](chemin/vers/votre/capture_accueil.png)

### 2. Interface Authentification
*(Capture du formulaire de login actionné par le router)*
![Capture Connexion](chemin/vers/votre/capture_connexion.png)

### 3. Gestion du Catalogue (Admin)
*(Capture de l'inventaire filtré par rôle)*
![Capture Interface Administrateur](chemin/vers/votre/capture_admin.png)

### 4. Rendu de Facture
*(Capture de la page facture finale)*
![Capture Facture](chemin/vers/votre/capture_facture.png)
