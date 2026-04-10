<?php
session_start();
require_once 'php/Modele.php';

// Sécurité : Seuls les admins peuvent voir cette page
if (!isset($_SESSION['client']) || $_SESSION['client']->EstAdmin != 1) {
    header('Location: index.php');
    exit();
}

$modele = new Modele();
$message = "";
$client = null;

if (isset($_GET['id'])) {
    $client = $modele->getClientById($_GET['id']);
}

if (!$client) {
    header('Location: admin_gestion.php');
    exit();
}

// Traitement de la modification
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ok = $modele->modifierClient(
        $_POST['id'],
        $_POST['nom'],
        $_POST['prenom'],
        $_POST['adresse'],
        $_POST['ville'],
        $_POST['cp'],
        $_POST['point'],
        isset($_POST['estAdmin']) ? 1 : 0
    );

    if ($ok) {
        header('Location: admin_gestion.php?msg=Client mis à jour');
        exit();
    } else {
        $message = "Erreur lors de la mise à jour.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier Utilisateur - Supermarché 2.0</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .edit-wrapper {
            max-width: 600px;
            margin: 30px auto;
            background: rgba(0, 0, 0, 0.2);
            border: 1px solid var(--glass-border);
            padding: 40px;
            border-radius: 20px;
            backdrop-filter: blur(12px);
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .full-width {
            grid-column: span 2;
        }

        .input-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .input-group label {
            color: var(--primary);
            font-weight: 700;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .input-group input, .input-group select {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--glass-border);
            padding: 12px;
            border-radius: 10px;
            color: #fff;
            outline: none;
            transition: var(--transition);
        }

        .input-group input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 10px var(--primary-glow);
            background: rgba(255, 255, 255, 0.1);
        }

        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 15px;
            background: rgba(52, 152, 219, 0.1);
            border-radius: 12px;
            border: 1px solid rgba(52, 152, 219, 0.2);
            cursor: pointer;
        }

        .checkbox-group input {
            width: 20px;
            height: 20px;
            cursor: pointer;
        }
    </style>
</head>
<body>

    <div class="container" style="max-width: 800px;">
        <div class="titre-1">Administration</div>
        <div class="titre-2">Modifier l'utilisateur #<?= $client->IdClient ?></div>

        <div class="edit-wrapper">
            <?php if($message): ?>
                <p style="color: #ef5350; text-align: center; margin-bottom: 20px;"><?= $message ?></p>
            <?php endif; ?>

            <form method="POST">
                <input type="hidden" name="id" value="<?= $client->IdClient ?>">
                
                <div class="form-grid">
                    <div class="input-group">
                        <label>Nom</label>
                        <input type="text" name="nom" value="<?= htmlspecialchars($client->Nom) ?>" required>
                    </div>
                    <div class="input-group">
                        <label>Prénom</label>
                        <input type="text" name="prenom" value="<?= htmlspecialchars($client->Prenom) ?>" required>
                    </div>
                    <div class="input-group full-width">
                        <label>Adresse</label>
                        <input type="text" name="adresse" value="<?= htmlspecialchars($client->Adresse) ?>" required>
                    </div>
                    <div class="input-group">
                        <label>Ville</label>
                        <input type="text" name="ville" value="<?= htmlspecialchars($client->Ville) ?>" required>
                    </div>
                    <div class="input-group">
                        <label>Code Postal</label>
                        <input type="text" name="cp" value="<?= htmlspecialchars($client->CodePostal) ?>" required>
                    </div>
                    <div class="input-group">
                        <label>Points Fidélité</label>
                        <input type="number" name="point" value="<?= $client->point ?>" required>
                    </div>
                    
                    <label class="checkbox-group">
                        <input type="checkbox" name="estAdmin" <?= $client->EstAdmin ? 'checked' : '' ?>>
                        <span style="color: var(--primary); font-weight: 700;">Accès Administrateur</span>
                    </label>
                </div>

                <div class="zone-boutons" style="margin-top: 30px; gap: 20px;">
                    <a href="admin_gestion.php" class="btn-carre" style="color: black; background: #94a3b8; border: none;">Annuler</a>
                    <button type="submit" class="btn-carre" style="background: var(--primary); color: white; border: none;">Sauvegarder</button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>
