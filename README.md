# 🛒 Supermarché 2.0

> Application web de gestion d'un supermarché développée en **PHP / MySQL**, avec authentification, gestion d'un panier, génération de factures et un panneau d'administration complet.

---

## 📸 Aperçu

### 🏠 Tableau de bord

![Tableau de bord](screenshots/dashboard.png)

### 🔐 Connexion

![Page de connexion](screenshots/login.png)

### 🆔 Inscription / Carte Fidélité

![Page d'inscription](screenshots/inscription.png)

### 🚀 Passer une commande (Rayons)

![Choisir un rayon](screenshots/commande.png)

### 🛍️ Catalogue Produits

![Liste des produits](screenshots/produits.png)

### 🧾 Facture

![Facture générée](screenshots/facture.png)

---

## ✨ Fonctionnalités

| Fonctionnalité          | Description                                                                         |
| ----------------------- | ----------------------------------------------------------------------------------- |
| 🏠 **Tableau de bord**  | Page d'accueil avec animation de lancement (splash screen) et navigation principale |
| 🔐 **Authentification** | Connexion par ID client + mot de passe, gestion de session PHP                      |
| 🆔 **Inscription**      | Création d'un compte adhérent avec carte de fidélité et mot magique                 |
| 🛒 **Panier**           | Sélection de produits par rayon, choix des quantités                                |
| 🧾 **Facture**          | Génération automatique de facture récapitulative avec détail des produits           |
| ⚙️ **Admin – Clients**  | CRUD complet sur les adhérents (ajouter, modifier, supprimer)                       |
| ⚙️ **Admin – Produits** | CRUD complet sur le catalogue produits avec upload d'image                          |
| 🏷️ **Points fidélité**  | Système de points attribués aux adhérents                                           |

---

## 🗂️ Structure du projet

```
Supermarche/
├── index.php               # Point d'entrée unique (Routeur)
├── models/
│   └── Modele.php          # Accès aux données (RBAC & PDO)
├── controllers/
│   ├── ControllerAuth.php  # Login / Inscription
│   ├── ControllerCatalog.php # Panier / Facture / Rayons
│   └── ControllerAdmin.php # Gestion Membres & Inventaire
├── views/
│   ├── layout.php          # Gabarit (Head, Footer, Container)
│   └── pages/              # Vues (Login, Home, Facture, etc.)
├── css/
│   └── style.css           # Design System
├── img/                    # Photos des produits
├── sql/
│   └── supermarche.sql     # Base de données
└── screenshots/            # Captures d'écran
```

---

## 🗄️ Base de données

### Schéma relationnel

```
adherent         famille
─────────        ────────
IdClient (PK)    IdFamille (PK)
Nom              NomFamille
Prenom
Adresse          produit
Ville            ────────
CodePostal       IdProduit (PK)
MotDePasse       NomProd
Date_naissance   Prix
                IdFamille (FK → famille)
                Image
role (client, admin_produits, admin_prix, admin_comptes, super_admin)
                 facture           contenir
                 ────────          ────────
                 NumFacture (PK)   NumFacture (FK)
                 DateFacture       IdProduit  (FK)
                 IdClient (FK)     Quantite
```

### Tables

| Table      | Description                                     | Nb enregistrements |
| ---------- | ----------------------------------------------- | ------------------ |
| `adherent` | Clients / adhérents                             | 5 (exemples)       |
| `famille`  | Rayons (boissons, légumes, fruits, boulangerie) | 4                  |
| `produit`  | Catalogue complet                               | **129 produits**   |
| `facture`  | Commandes passées                               | 4 (exemples)       |
| `contenir` | Lignes de facture (produit + quantité)          | 4 (exemples)       |

---

## ⚙️ Installation

### Prérequis

- [XAMPP](https://www.apachefriends.org/) (ou tout serveur Apache + PHP + MySQL)
- PHP **8.0+**
- MariaDB / MySQL **10.4+**

### Étapes

1. **Cloner / copier le projet** dans le dossier `htdocs` de XAMPP :

   ```bash
   git clone <url-du-repo> /Applications/XAMPP/xamppfiles/htdocs/Supermarche
   ```

2. **Démarrer XAMPP** : lancer Apache et MySQL.

3. **Importer la base de données** :
   - Créer une base nommée **`supermarche`**
   - Importer `sql/supermarche.sql`

4. **Accéder à l'application** :
   ```
   http://localhost/Supermarche/
   ```

---

## 🔑 Comptes de test

| ID Client | Nom      | Prénom | Mot de passe | Rôle                |
| :-------: | -------- | ------ | ------------ | ------------------- |
|    `1`    | toto     | tata   | `azerty1`    | `client`            |
|    `2`    | lola     | marko  | `azerty2`    | `admin_produits`    |
|    `3`    | lola     | marko  | `azerty2`    | `admin_prix`        |
|    `4`    | bombe    | yanis  | `azerty3`    | `admin_comptes`     |
|    `5`    | ONEPIECE | Tina   | `1234AZER`   | `super_admin`       |
|    `6`    | cleaner  | jean   | `cleanit`    | `admin_suppression` |

> [!NOTE]
> La sécurité est désormais 100% MVC. Toute tentative d'accès manuel à une page protégée sans le bon `role` redirige vers l'accueil.

---

## 🧪 Guide de Test du Router MVC

Pour vérifier le bon fonctionnement, utilisez les actions du routeur :

1. **Connexion** : `index.php?action=login`
2. **Rayons** : `index.php?action=rayons`
3. **Admin Membres** : `index.php?action=admin_membres` (ID 5 requis)
4. **Admin Inventaire** : `index.php?action=admin_inventaire` (ID 2 ou 5 requis)

---

## 🛠️ Technologies utilisées

| Technologie      | Usage                             |
| ---------------- | --------------------------------- |
| **PHP 8**        | Backend MVC (Controllers/Routing) |
| **PDO (MySQL)**  | Couche de données isolée          |
| **HTML5 / CSS3** | UI Pro-Grade                      |
| **Vanilla JS**   | Micro-animations                  |

---

## 📁 Données de configuration

Le fichier de connexion unique se trouve dans `models/Modele.php` :

```php
$this->bdd = new PDO('mysql:host=localhost;dbname=supermarche;charset=utf8', 'root', '');
```

> Modifier `host`, `dbname`, l'utilisateur et le mot de passe selon votre configuration.

---

## 📄 Licence

Projet scolaire — usage libre à des fins pédagogiques.

sessionStorage.removeItem('splashPlayed')
