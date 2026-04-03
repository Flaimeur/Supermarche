<?php
session_start();
require_once 'php/Modele.php';

// Sécurité : Seuls les admins peuvent voir cette page
// Sécurité : Seuls les admins autorisés peuvent voir cette page
$role_sess = $_SESSION['client']->role ?? 'client';
if (!isset($_SESSION['client']) || ($role_sess !== 'super_admin' && $role_sess !== 'admin_produits')) {
    header('Location: index.php');
    exit();
}

$modele = new Modele();
$message = "";
$familles = $modele->getFamilles();

// Traitement de l'ajout
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $prix = $_POST['prix'];
    $idFamille = $_POST['idFamille'];
    $image = !empty($_POST['image']) ? $_POST['image'] : 'default.png';

    $ok = $modele->ajouterProduit($nom, $prix, $idFamille, $image);

    if ($ok) {
        header('Location: admin_produits.php?msg=Produit ajouté avec succès');
        exit();
    } else {
        $message = "Erreur lors de l'ajout du produit.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un Produit - Supermarché 2.0</title>
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
            grid-template-columns: 1fr;
            gap: 20px;
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

        .input-group input:focus, .input-group select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 10px var(--primary-glow);
            background: rgba(255, 255, 255, 0.1);
        }
    </style>
</head>
<body>

    <div class="container" style="max-width: 800px;">
        <div class="titre-1">Administration</div>
        <div class="titre-2">Ajouter un nouveau produit</div>

        <div class="edit-wrapper">
            <?php if($message): ?>
                <p style="color: #ef5350; text-align: center; margin-bottom: 20px; font-weight: 600;"><?= $message ?></p>
            <?php endif; ?>

            <form method="POST">
                <div class="form-grid">
                    <div class="input-group">
                        <label>Nom du Produit</label>
                        <input type="text" name="nom" required placeholder="Ex: Pack d'Eau Minérale">
                    </div>
                    
                    <div class="input-group">
                        <label>Prix (en €)</label>
                        <input type="number" step="0.01" name="prix" required placeholder="Ex: 2.50">
                    </div>
                    
                    <div class="input-group">
                        <label>Rayon (Famille)</label>
                        <select name="idFamille" required>
                            <option value="" disabled selected>-- Choisissez une catégorie --</option>
                            <?php foreach ($familles as $f): ?>
                                <option value="<?= $f->IdFamille ?>"><?= htmlspecialchars($f->NomFamille) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="input-group">
                        <label>Nom de l'Image (optionnel)</label>
                        <input type="text" name="image" placeholder="Ex: eau.png (laisser vide pour l'image par défaut)">
                    </div>
                </div>

                <div class="zone-boutons" style="margin-top: 30px; gap: 20px;">
                    <a href="admin_produits.php" class="btn-carre" style="color: black; background: #94a3b8; border: none;">Annuler</a>
                    <button type="submit" class="btn-carre" style="background: #2ecc71; color: white; border: none; box-shadow: 0 0 15px rgba(46, 204, 113, 0.4);">➕ Ajouter le produit</button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>
