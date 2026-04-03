<?php
class ControllerAdmin {
    private $modele;

    public function __construct($modele) {
        $this->modele = $modele;
    }

    private function checkAccess($allowedRoles) {
        $role = $_SESSION['client']->role ?? 'client';
        if (!isset($_SESSION['client']) || !in_array($role, $allowedRoles)) {
            header('Location: index.php');
            exit();
        }
        return $role;
    }

    public function membres() {
        $role_sess = $this->checkAccess(['super_admin', 'admin_comptes']);
        
        $notif = isset($_GET['msg']) ? $_GET['msg'] : "";
        $clients = $this->modele->getAllClients();
        $title = "Gestion Utilisateurs - Supermarché 2.0";
        
        ob_start();
        require 'views/pages/admin_membres.php';
        $content = ob_get_clean();
        
        require 'views/layout.php';
    }

    public function delClient() {
        $role_sess = $this->checkAccess(['super_admin', 'admin_comptes']);
        
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            if ($id == $_SESSION['client']->IdClient) {
                header('Location: index.php?action=admin_membres&msg=Erreur : Vous ne pouvez pas supprimer votre propre compte.');
            } else {
                $res = $this->modele->supprimerClient($id);
                if ($res === true) {
                    header('Location: index.php?action=admin_membres&msg=Utilisateur supprimé avec succès.');
                } else {
                    header('Location: index.php?action=admin_membres&msg=Erreur lors de la suppression.');
                }
            }
        }
        exit();
    }

    public function inventaire() {
        $role_sess = $this->checkAccess(['super_admin', 'admin_produits', 'admin_prix', 'admin_suppression']);
        
        $notif = isset($_GET['msg']) ? $_GET['msg'] : "";
        $produits = $this->modele->getAllProduitsWithFamille();
        $title = "Gestion Produits - Supermarché 2.0";
        
        // Permissions spécifiques pour la vue
        $can_manage_catalog = ($role_sess === 'super_admin' || $role_sess === 'admin_produits');
        $can_edit_prices = ($role_sess === 'super_admin' || $role_sess === 'admin_prix');
        $can_delete = ($role_sess === 'super_admin' || $role_sess === 'admin_suppression');

        ob_start();
        require 'views/pages/admin_inventaire.php';
        $content = ob_get_clean();
        
        require 'views/layout.php';
    }

    public function delProduit() {
        $role_sess = $this->checkAccess(['super_admin', 'admin_suppression']);
        
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $res = $this->modele->supprimerProduit($id);
            if ($res === true) {
                header('Location: index.php?action=admin_inventaire&msg=Produit supprimé.');
            } else {
                header('Location: index.php?action=admin_inventaire&msg=Erreur lors de la suppression.');
            }
        }
        exit();
    }

    public function editClient() {
        $role_sess = $this->checkAccess(['super_admin', 'admin_comptes']);
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $ok = $this->modele->modifierClient(
                $_POST['id'], $_POST['nom'], $_POST['prenom'], 
                $_POST['adresse'], $_POST['ville'], $_POST['cp'], 
                $_POST['point'], $_POST['role']
            );
            header('Location: index.php?action=admin_membres&msg=' . ($ok ? "Client mis à jour" : "Erreur"));
            exit();
        }

        if (isset($_GET['id'])) {
            $client = $this->modele->getClientById($_GET['id']);
            if (!$client) { header('Location: index.php?action=admin_membres'); exit(); }
            
            $title = "Modifier Utilisateur - Supermarché 2.0";
            ob_start();
            require 'views/pages/edit_client.php';
            $content = ob_get_clean();
            require 'views/layout.php';
        }
    }

    public function addProduit() {
        $role_sess = $this->checkAccess(['super_admin', 'admin_produits']);
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $ok = $this->modele->ajouterProduit(
                $_POST['nom'], $_POST['prix'], 
                $_POST['idFamille'], $_POST['image']
            );
            header('Location: index.php?action=admin_inventaire&msg=' . ($ok ? "Produit ajouté" : "Erreur"));
            exit();
        }

        $familles = $this->modele->getFamilles();
        $title = "Nouveau Produit - Supermarché 2.0";
        ob_start();
        require 'views/pages/add_produit.php';
        $content = ob_get_clean();
        require 'views/layout.php';
    }

    public function editProduit() {
        $role_sess = $this->checkAccess(['super_admin', 'admin_produits', 'admin_prix', 'admin_suppression']);
        
        $can_manage_catalog = ($role_sess === 'super_admin' || $role_sess === 'admin_produits');
        $can_edit_prices = ($role_sess === 'super_admin' || $role_sess === 'admin_prix');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $produit = $this->modele->getProduit($_POST['id']);
            $nom = $can_manage_catalog ? $_POST['nom'] : $produit->NomProd;
            $prix = $can_edit_prices ? $_POST['prix'] : $produit->Prix;
            $idFamille = $can_manage_catalog ? $_POST['idFamille'] : $produit->IdFamille;
            $image = $can_manage_catalog ? (!empty($_POST['image']) ? $_POST['image'] : 'default.png') : $produit->Image;

            $ok = $this->modele->modifierProduit($_POST['id'], $nom, $prix, $idFamille, $image);
            header('Location: index.php?action=admin_inventaire&msg=' . ($ok ? "Produit modifié" : "Erreur"));
            exit();
        }

        if (isset($_GET['id'])) {
            $produit = $this->modele->getProduit($_GET['id']);
            $familles = $this->modele->getFamilles();
            $title = "Modifier Produit - Supermarché 2.0";
            ob_start();
            require 'views/pages/edit_produit.php';
            $content = ob_get_clean();
            require 'views/layout.php';
        }
    }
}
