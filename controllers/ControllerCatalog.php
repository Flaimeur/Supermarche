<?php
class ControllerCatalog {
    private $modele;

    public function __construct($modele) {
        $this->modele = $modele;
    }

    public function home() {
        $title = "Supermarché 2.0 - Accueil";
        $no_container = true;
        // On récupère les infos de session pour l'affichage
        $client = isset($_SESSION['client']) ? $_SESSION['client'] : null;
        
        ob_start();
        require 'views/pages/home.php';
        $content = ob_get_clean();
        
        require 'views/layout.php';
    }

    public function rayons() {
        $title = "Choix du rayon - Supermarché 2.0";
        $familles = $this->modele->getFamilles();
        
        ob_start();
        require 'views/pages/rayons.php';
        $content = ob_get_clean();
        
        require 'views/layout.php';
    }

    public function produits() {
        if (!isset($_GET['famille'])) {
            header('Location: index.php?action=rayons');
            exit();
        }
        
        $idFamille = $_GET['famille'];
        $produits = $this->modele->getProduitsParFamille($idFamille);
        $title = "Nos produits - Supermarché 2.0";
        
        ob_start();
        require 'views/pages/produits.php';
        $content = ob_get_clean();
        
        require 'views/layout.php';
    }

    public function quantite() {
        if (!isset($_GET['id'])) {
            header('Location: index.php?action=rayons');
            exit();
        }
        
        $idProduit = $_GET['id'];
        $produit = $this->modele->getProduit($idProduit);
        $title = "Choisir la quantité - Supermarché 2.0";
        
        ob_start();
        require 'views/pages/quantite.php';
        $content = ob_get_clean();
        
        require 'views/layout.php';
    }

    public function facture() {
        // Init Panier
        if (!isset($_SESSION['panier'])) {
            $_SESSION['panier'] = [];
        }

        // 1. Suppression totale (Vider)
        if (isset($_GET['subaction']) && $_GET['subaction'] === 'vider') {
            $_SESSION['panier'] = [];
            header("Location: index.php?action=facture");
            exit();
        }

        // 2. Suppression d'un article
        if (isset($_POST['action_suppression']) && isset($_POST['selection_produit'])) {
            $idASupprimer = $_POST['selection_produit'];
            unset($_SESSION['panier'][$idASupprimer]);
            header("Location: index.php?action=facture");
            exit();
        }

        // 3. Ajout produit (depuis quantite.php)
        if (isset($_POST['idProduit']) && isset($_POST['quantite'])) {
            $id = $_POST['idProduit'];
            $qty = (int)$_POST['quantite'];
            
            if (isset($_SESSION['panier'][$id])) {
                $_SESSION['panier'][$id] += $qty;
            } else {
                $_SESSION['panier'][$id] = $qty;
            }
            header("Location: index.php?action=facture");
            exit();
        }

        // 4. Calculs pour l'affichage
        $totalGlobalHT = 0;
        $panierDetail = [];
        foreach ($_SESSION['panier'] as $idProd => $qte) {
            $p = $this->modele->getProduit($idProd);
            if ($p) {
                $p->qte = $qte;
                $p->totalLigne = $p->Prix * $qte;
                $totalGlobalHT += $p->totalLigne;
                $panierDetail[] = $p;
            }
        }

        // Détermination du lien "Autre produit"
        $lienAutreProduit = "index.php?action=rayons";
        if (!empty($panierDetail)) {
            $dernierProduit = end($panierDetail);
            $lienAutreProduit = "index.php?action=produits&famille=" . $dernierProduit->IdFamille;
        }

        $title = "Votre Facture - Supermarché 2.0";
        $dateFacture = date("d/m/Y");
        $numFacture  = 4389; 
        $numClient   = isset($_SESSION['client']) ? $_SESSION['client']->IdClient : "INVITÉ";
        $pointsClient = isset($_SESSION['client']) ? $_SESSION['client']->point : 0;

        ob_start();
        require 'views/pages/facture.php';
        $content = ob_get_clean();
        
        require 'views/layout.php';
    }
}
