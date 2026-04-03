<?php
session_start();
require_once 'models/Modele.php';

// Initialisation du modèle
$modele = new Modele();

// Routage simple
$action = isset($_GET['action']) ? $_GET['action'] : 'home';

// Chargement des contrôleurs (en prod, on utiliserait un autoloader)
require_once 'controllers/ControllerAuth.php';
require_once 'controllers/ControllerCatalog.php';
require_once 'controllers/ControllerAdmin.php';

$ctrlAuth = new ControllerAuth($modele);
$ctrlCatalog = new ControllerCatalog($modele);
$ctrlAdmin = new ControllerAdmin($modele);

// Dispatcher
switch ($action) {
    case 'home':
        $ctrlCatalog->home();
        break;

    // --- AUTHENTIFICATION ---
    case 'login':
        $ctrlAuth->login();
        break;
    case 'login_post':
        $ctrlAuth->loginPost();
        break;
    case 'logout':
        $ctrlAuth->logout();
        break;
    case 'inscription':
        $ctrlAuth->inscription();
        break;
    case 'inscription_post':
        $ctrlAuth->inscriptionPost();
        break;

    // --- CATALOGUE / COMMANDE ---
    case 'rayons':
        $ctrlCatalog->rayons();
        break;
    case 'produits':
        $ctrlCatalog->produits();
        break;
    case 'quantite':
        $ctrlCatalog->quantite();
        break;
    case 'facture':
        $ctrlCatalog->facture();
        break;

    // --- ADMINISTRATION ---
    case 'admin_membres':
        $ctrlAdmin->membres();
        break;
    case 'admin_inventaire':
        $ctrlAdmin->inventaire();
        break;
    case 'add_produit':
        $ctrlAdmin->addProduit();
        break;
    case 'edit_produit':
        $ctrlAdmin->editProduit();
        break;
    case 'del_produit':
        $ctrlAdmin->delProduit();
        break;
    case 'edit_client':
        $ctrlAdmin->editClient();
        break;
    case 'del_client':
        $ctrlAdmin->delClient();
        break;

    default:
        $ctrlCatalog->home();
        break;
}