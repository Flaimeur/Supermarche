<?php
session_start();
require_once 'php/Modele.php';

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['num_client'];
    $mdp = $_POST['mdp'];

    $modele = new Modele();
    $client = $modele->verifierClient($id, $mdp);

    if ($client) {
        $_SESSION['client'] = $client;
        header('Location: index.php');
        exit();
    } else {
        $message = "Identifiant ou mot de passe incorrect.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion - Supermarché 2.0</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .login-box {
            max-width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>

    <div class="container login-box">
        <div class="titre-1">SUPERMARCHÉ 2.0</div>
        <div class="titre-2">Espace Client</div>

        <?php if($message): ?>
            <p style="color: #ef5350; font-weight: bold; margin-bottom: 20px;"><?= $message ?></p>
        <?php endif; ?>

        <form method="POST" action="login.php">
            <div class="input-row">
                <label>Numéro Client</label>
                <input type="text" name="num_client" required placeholder="Ex: 123">
            </div>

            <div class="input-row">
                <label>Mot de passe</label>
                <input type="password" name="mdp" required>
            </div>

            <div class="zone-boutons">
                <a href="index.php" class="bouton-menu">Retour</a>
                <button type="submit" class="bouton-menu btn-blue">Se connecter</button>
            </div>
        </form>

        <p style="margin-top: 30px; color: var(--text-dim);">
            Pas encore de compte ? <a href="inscription.php" style="color: var(--primary); text-decoration: none;">Inscrivez-vous ici</a>
        </p>
    </div>

</body>
</html>
