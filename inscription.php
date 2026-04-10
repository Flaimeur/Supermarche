<?php
require_once 'php/Modele.php';

// Calcul de la date limite pour le champ HTML (interdit de cliquer après cette date)
$dateMajorite = date('Y-m-d', strtotime('-18 years'));

$message = "";

// Si le formulaire est envoyé
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // 1. On calcule l'âge côté serveur (Sécurité)
    $dateNaissance = new DateTime($_POST['date_naissance']);
    $aujourdhui = new DateTime();
    $age = $aujourdhui->diff($dateNaissance)->y;

    // 2. Vérifications
    if ($age < 18) {
        $message = "Vous devez être majeur pour vous inscrire.";
    } 
    elseif ($_POST['mdp'] !== $_POST['confirm_mdp']) {
        $message = "Les mots de passe ne correspondent pas.";
    } 
    else {
        // 3. Tout est bon, on enregistre
        $modele = new Modele();
        $ok = $modele->ajouterClient(
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
            echo "<script>alert('Inscription réussie !'); window.location='index.php';</script>";
            exit();
        } else {
            $message = "Erreur lors de l'enregistrement.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        /* Petits ajustements pour centrer le formulaire d'inscription */
        .form-wrapper {
            max-width: 600px;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            gap: 15px;
            padding: 20px 0;
        }
        /* On force les labels à être un peu plus larges pour aligner proprement */
        .input-row label {
            width: 180px;
        }
        .input-row input {
            width: 250px; /* Champs plus larges */
        }
    </style>
</head>
<body>

    <div class="container" style="max-width: 850px;"> 
        
        <div class="titre-1">SUPERMARCHÉ 2.0</div>
        <div class="titre-2">Inscription</div>

        <p style="text-align: center; color: var(--text-dim); margin-bottom: 30px;">
            Veuillez saisir les informations vous concernant
        </p>

        <?php if($message): ?>
            <p style="color: red; text-align: center; font-weight: bold;"><?= $message ?></p>
        <?php endif; ?>

        <form method="POST" action="inscription.php">
            <div class="form-wrapper">
                
                <div class="input-row">
                    <label>Votre Numéro</label>
                    <input type="text" disabled placeholder="(Automatique)"  style="background-color: #e0e0e0; color: #66666675; cursor: not-allowed;">
                </div>

                <div class="input-row">
                    <label>Votre Nom</label>
                    <input type="text" name="nom" required>
                </div>

                <div class="input-row">
                    <label>Votre prénom</label>
                    <input type="text" name="prenom" required>
                </div>

                <div class="input-row">
                    <label>Votre adresse</label>
                    <input type="text" name="adresse" required>
                </div>

                <div class="input-row">
                    <label>Votre ville</label>
                    <input type="text" name="ville" required>
                </div>

                <div class="input-row">
                    <label>Votre code postal</label>
                    <input type="text" name="cp" required>
                </div>

                <div class="input-row">
                    <label>Votre mot de passe</label>
                    <input type="password" name="mdp" required>
                </div>

                <div class="input-row">
                    <label>Confirmer MPD</label>
                    <input type="password" name="confirm_mdp" required>
                </div>

                <div class="input-row">
                    <label>Votre Date de Naissance</label>
                    <input type="date" name="date_naissance" required max="<?= $dateMajorite ?>">
                </div>

                <div class="input-row">
                    <label>Vos points</label>
                    <input type="text" value="0" readonly style="background-color: #e0e0e0; color: #66666675; cursor: not-allowed;">
                </div>

                <div class="input-row">
                    <label>Votre mot magique</label>
                    <input type="text" name="mot_magique" required>
                </div>

            </div>

            <div class="boutons-grid-filaire" style="justify-content: space-around;">
                <a href="index.php" class="btn-carre" style="color: black;">
                    Annuler
                </a>

                <button type="submit" class="btn-carre" style="font-weight: bold;">
                    Valider
                </button>
            </div>
        </form>

    </div>

</body>
</html>