<?php
session_start();

/**
 * FRONT CONTROLLER - Supermarché 2.0
 * Point d'entrée unique de l'application MVC
 */

// 1. Initialisation des modèles et contrôleurs
require_once 'models/Modele.php';
require_once 'controllers/ControllerAuth.php';
require_once 'controllers/ControllerCatalog.php';
require_once 'controllers/ControllerAdmin.php';

$modele = new Modele();

// 2. Récupération de l'action demandée (par défaut 'home')
$action = isset($_GET['action']) ? $_GET['action'] : 'home';

try {
    switch ($action) {
        
        // --- PAGE D'ACCUEIL ---
        case 'home':
            $title = "Bienvenue - Supermarché 2.0";
            $no_container = true;
            ob_start();
            require 'views/pages/home.php';
            $content = ob_get_clean();
            require 'views/layout.php';
            break;

        // --- AUTHENTIFICATION ---
        case 'login':
        case 'login_post':
            $ctrl = new ControllerAuth($modele);
            if ($_SERVER['REQUEST_METHOD'] === 'POST' || $action === 'login_post') {
                $ctrl->loginPost();
            } else {
                $ctrl->login();
            }
            break;

        case 'logout':
            $ctrl = new ControllerAuth($modele);
            $ctrl->logout();
            break;

        case 'forgot_password':
            $ctrl = new ControllerAuth($modele);
            $ctrl->forgotPassword();
            break;
        case 'forgot_password_post':
            $ctrl = new ControllerAuth($modele);
            $ctrl->forgotPasswordPost();
            break;
        case 'reset_password':
            $ctrl = new ControllerAuth($modele);
            $ctrl->resetPassword();
            break;
        case 'reset_password_post':
            $ctrl = new ControllerAuth($modele);
            $ctrl->resetPasswordPost();
            break;

        case 'inscription':
        case 'inscription_post':
            $ctrl = new ControllerAuth($modele);
            if ($_SERVER['REQUEST_METHOD'] === 'POST' || $action === 'inscription_post') {
                $ctrl->inscriptionPost();
            } else {
                $ctrl->inscription();
            }
            break;

        // --- CATALOGUE & COMMANDES ---
        case 'rayons':
            $ctrl = new ControllerCatalog($modele);
            $ctrl->rayons();
            break;

        case 'produits':
            $ctrl = new ControllerCatalog($modele);
            $ctrl->produits();
            break;

        case 'quantite':
            $ctrl = new ControllerCatalog($modele);
            $ctrl->quantite();
            break;

        case 'facture':
            $ctrl = new ControllerCatalog($modele);
            $ctrl->facture();
            break;

        // --- ADMINISTRATION ---
        case 'admin_membres':
            $ctrl = new ControllerAdmin($modele);
            $ctrl->membres();
            break;

        case 'admin_del_client':
            $ctrl = new ControllerAdmin($modele);
            $ctrl->delClient();
            break;

        case 'admin_edit_client':
            $ctrl = new ControllerAdmin($modele);
            $ctrl->editClient();
            break;

        case 'admin_inventaire':
            $ctrl = new ControllerAdmin($modele);
            $ctrl->inventaire();
            break;

        case 'admin_add_produit':
            $ctrl = new ControllerAdmin($modele);
            $ctrl->addProduit();
            break;

        case 'admin_edit_produit':
            $ctrl = new ControllerAdmin($modele);
            $ctrl->editProduit();
            break;

        case 'admin_del_produit':
            $ctrl = new ControllerAdmin($modele);
            $ctrl->delProduit();
            break;

        // --- ERREUR 404 ---
        default:
            header("HTTP/1.0 404 Not Found");
            echo "Action non trouvée dans le routeur.";
            break;
    }
} catch (Exception $e) {
    echo 'Erreur critique : ' . $e->getMessage();
}