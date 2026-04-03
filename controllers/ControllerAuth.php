<?php
class ControllerAuth {
    private $modele;

    public function __construct($modele) {
        $this->modele = $modele;
    }

    public function login() {
        $title = "Connexion - Supermarché 2.0";
        $message = isset($_GET['msg']) ? $_GET['msg'] : "";
        
        ob_start();
        require 'views/pages/login.php';
        $content = ob_get_clean();
        
        require 'views/layout.php';
    }

    public function loginPost() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['num_client'];
            $mdp = $_POST['mdp'];

            $client = $this->modele->verifierClient($id, $mdp);

            if ($client) {
                $_SESSION['client'] = $client;
                header('Location: index.php');
                exit();
            } else {
                header('Location: index.php?action=login&msg=Identifiant ou mot de passe incorrect.');
                exit();
            }
        }
    }

    public function logout() {
        session_destroy();
        header('Location: index.php');
        exit();
    }

    public function inscription() {
        $title = "Inscription - Supermarché 2.0";
        // Calcul de la date limite pour le champ HTML (18 ans)
        $dateMajorite = date('Y-m-d', strtotime('-18 years'));
        $message = "";
        
        ob_start();
        require 'views/pages/inscription.php';
        $content = ob_get_clean();
        
        require 'views/layout.php';
    }

    public function inscriptionPost() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Calcul de l'âge côté serveur
            $dateNaissance = new DateTime($_POST['date_naissance']);
            $aujourdhui = new DateTime();
            $age = $aujourdhui->diff($dateNaissance)->y;

            if ($age < 18) {
                $msg = "Vous devez être majeur pour vous inscrire.";
                header("Location: index.php?action=inscription&error=" . urlencode($msg));
                exit();
            } 
            elseif ($_POST['mdp'] !== $_POST['confirm_mdp']) {
                $msg = "Les mots de passe ne correspondent pas.";
                header("Location: index.php?action=inscription&error=" . urlencode($msg));
                exit();
            } 
            else {
                $ok = $this->modele->ajouterClient(
                    $_POST['nom'],
                    $_POST['prenom'],
                    $_POST['adresse'],
                    $_POST['ville'],
                    $_POST['cp'],
                    $_POST['mdp'],
                    $_POST['date_naissance'],
                    $_POST['mot_magique']
                );

                if ($ok) {
                    header('Location: index.php?action=login&msg=Inscription réussie !');
                    exit();
                } else {
                    $msg = "Erreur lors de l'enregistrement.";
                    header("Location: index.php?action=inscription&error=" . urlencode($msg));
                    exit();
                }
            }
        }
    }
}
