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

    // --- MOT DE PASSE OUBLIÉ ---

    public function forgotPassword() {
        $title = "Récupération de compte - Supermarché 2.0";
        $message = isset($_GET['msg']) ? $_GET['msg'] : "";
        $error = isset($_GET['error']) ? $_GET['error'] : "";
        
        ob_start();
        require 'views/pages/forgot_password.php';
        $content = ob_get_clean();
        require 'views/layout.php';
    }

    public function forgotPasswordPost() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['num_client'];
            $motMagique = $_POST['mot_magique'];

            if ($this->modele->verifyMagicWord($id, $motMagique)) {
                $_SESSION['reset_client_id'] = $id;
                header('Location: index.php?action=reset_password');
                exit();
            } else {
                header('Location: index.php?action=forgot_password&error=Identifiant ou mot magique incorrect.');
                exit();
            }
        }
    }

    public function resetPassword() {
        if (!isset($_SESSION['reset_client_id'])) {
            header('Location: index.php?action=forgot_password');
            exit();
        }

        $title = "Nouveau mot de passe - Supermarché 2.0";
        $error = isset($_GET['error']) ? $_GET['error'] : "";

        ob_start();
        require 'views/pages/reset_password.php';
        $content = ob_get_clean();
        require 'views/layout.php';
    }

    public function resetPasswordPost() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['reset_client_id'])) {
            $mdp = $_POST['mdp'];
            $confirm = $_POST['confirm_mdp'];
            $id = $_SESSION['reset_client_id'];

            if ($mdp !== $confirm) {
                header('Location: index.php?action=reset_password&error=Les mots de passe ne correspondent pas.');
                exit();
            }

            $ok = $this->modele->updatePassword($id, $mdp);
            if ($ok) {
                unset($_SESSION['reset_client_id']);
                header('Location: index.php?action=login&msg=Mot de passe réinitialisé avec succès !');
                exit();
            } else {
                header('Location: index.php?action=reset_password&error=Erreur lors de la mise à jour.');
                exit();
            }
        }
    }
}
