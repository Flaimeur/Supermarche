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

| Fonctionnalité | Description |
|---|---|
| 🏠 **Tableau de bord** | Page d'accueil avec animation de lancement (splash screen) et navigation principale |
| 🔐 **Authentification** | Connexion par ID client + mot de passe, gestion de session PHP |
| 🆔 **Inscription** | Création d'un compte adhérent avec carte de fidélité et mot magique |
| 🛒 **Panier** | Sélection de produits par rayon, choix des quantités |
| 🧾 **Facture** | Génération automatique de facture récapitulative avec détail des produits |
| ⚙️ **Admin – Clients** | CRUD complet sur les adhérents (ajouter, modifier, supprimer) |
| ⚙️ **Admin – Produits** | CRUD complet sur le catalogue produits avec upload d'image |
| 🏷️ **Points fidélité** | Système de points attribués aux adhérents |

---

## 🗂️ Structure du projet

```
Supermarche/
├── index.php               # Tableau de bord (page d'accueil)
├── login.php               # Page de connexion
├── logout.php              # Déconnexion (destroy session)
├── inscription.php         # Inscription / Carte fidélité
├── Passer_commande.php     # Choix du rayon → panier
├── produits.php            # Catalogue produits d'un rayon
├── quantite.php            # Saisie des quantités
├── facture.php             # Récapitulatif / Facture
├── admin_gestion.php       # Admin : gestion des clients
├── admin_produits.php      # Admin : gestion des produits
├── add_produit.php         # Admin : ajout d'un produit
├── edit_produit.php        # Admin : modification d'un produit
├── edit_client.php         # Admin : modification d'un client
├── php/
│   └── Modele.php          # Couche d'accès aux données (PDO)
├── css/
│   └── style.css           # Styles globaux (thème sombre)
├── img/                    # Images des produits
├── sql/
│   └── supermarche.sql     # Dump complet de la base de données
└── screenshots/            # Captures d'écran (README)
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
point            IdFamille (FK → famille)
MotMagique       Image
role (client, admin_produits, admin_prix, admin_comptes, super_admin)
                 facture           contenir
                 ────────          ────────
                 NumFacture (PK)   NumFacture (FK)
                 DateFacture       IdProduit  (FK)
                 IdClient (FK)     Quantite
```

### Tables

| Table | Description | Nb enregistrements |
|---|---|---|
| `adherent` | Clients / adhérents | 5 (exemples) |
| `famille` | Rayons (boissons, légumes, fruits, boulangerie) | 4 |
| `produit` | Catalogue complet | **129 produits** |
| `facture` | Commandes passées | 4 (exemples) |
| `contenir` | Lignes de facture (produit + quantité) | 4 (exemples) |

### Familles de produits

| ID | Rayon | Exemples |
|---|---|---|
| 1 | 🥤 Boissons | Pepsi, Coca-Cola Zéro, Red Bull, Champagne… |
| 2 | 🥕 Légumes | Carottes, Courgettes, Poivrons, Champignons… |
| 3 | 🍓 Fruits | Fraises, Mangue, Ananas, Cerises… |
| 4 | 🥖 Boulangerie | Pain, Croissants, Éclairs, Sandwichs… |

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

2. **Démarrer XAMPP** : lancer Apache et MySQL depuis le panneau de contrôle.

3. **Importer la base de données** :
   - Ouvrir [phpMyAdmin](http://localhost/phpmyadmin)
   - Créer une base de données nommée **`supermarche`**
   - Importer le fichier `sql/supermarche.sql`

4. **Accéder à l'application** :
   ```
   http://localhost/Supermarche/
   ```

---

## | ID Client | Nom | Prénom | Mot de passe | Rôle |
|---|---|---|---|---|
| `1` | toto | tata | `azerty1` | `client` |
| `2` | lola | marko | `azerty2` | `admin_produits` |
| `3` | lola | marko | `azerty2` | `admin_prix` |
| `4` | bombe | yanis | `azerty3` | `admin_comptes` |
| `5` | ONEPIECE | Tina | `1234AZER` | `super_admin` |

> **Note :** Le niveau d'accès est désormais géré par le champ `role` (ex: `super_admin` pour l'accès total).

---

## 🛠️ Technologies utilisées

| Technologie | Usage |
|---|---|
| **PHP 8** | Backend, sessions, logique métier |
| **PDO (MySQL)** | Accès sécurisé à la base de données |
| **MariaDB / MySQL** | Stockage des données |
| **HTML5 / CSS3** | Interface utilisateur |
| **Vanilla JS** | Animation splash screen |
| **XAMPP** | Stack de développement local |

---

## 🏗️ Architecture

L'application suit le pattern **MVC simplifié** :

- **Modèle** → `php/Modele.php` : toutes les requêtes SQL via PDO
- **Vue** → les fichiers `.php` racine (HTML + PHP mélangés)
- **Contrôleur** → logique intégrée dans chaque page PHP

### Sécurités mises en place

- ✅ Requêtes préparées PDO (protection contre les injections SQL)
- ✅ `htmlspecialchars()` sur les affichages utilisateur
- ✅ Sessions PHP pour l'authentification
- ✅ Transactions SQL pour les suppressions en cascade

---

## 📁 Données de configuration

Le fichier de connexion se trouve dans `php/Modele.php` :

```php
$this->bdd = new PDO('mysql:host=localhost;dbname=supermarche;charset=utf8', 'root', '');
```

> Modifier `host`, `dbname`, l'utilisateur et le mot de passe selon votre configuration.

---

## 📄 Licence

Projet scolaire — usage libre à des fins pédagogiques.
