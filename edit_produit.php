<?php
session_start();
require_once 'php/Modele.php';

// Sécurité : Seuls les admins peuvent voir cette page
// Sécurité : Seuls les admins autorisés peuvent voir cette page
$role_sess = $_SESSION['client']->role ?? 'client';
$can_manage_catalog = ($role_sess === 'super_admin' || $role_sess === 'admin_produits');
$can_edit_prices = ($role_sess === 'super_admin' || $role_sess === 'admin_prix');

if (!isset($_SESSION['client']) || ($role_sess !== 'super_admin' && $role_sess !== 'admin_produits' && $role_sess !== 'admin_prix')) {
    header('Location: index.php');
    exit();
}

$modele = new Modele();
$message = "";
$produit = null;
$familles = $modele->getFamilles();

if (isset($_GET['id'])) {
    $produit = $modele->getProduit($_GET['id']);
}

if (!$produit) {
    header('Location: admin_produits.php');
    exit();
}

// Traitement de la modification
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Si l'utilisateur est admin_prix, il ne peut modifier QUE le prix.
    // On récupère les autres données du produit existant pour ne pas les écraser par erreur.
    $nom = $can_manage_catalog ? $_POST['nom'] : $produit->NomProd;
    $prix = $can_edit_prices ? $_POST['prix'] : $produit->Prix;
    $idFamille = $can_manage_catalog ? $_POST['idFamille'] : $produit->IdFamille;
    $image = $can_manage_catalog ? (!empty($_POST['image']) ? $_POST['image'] : 'default.png') : $produit->Image;

    $ok = $modele->modifierProduit(
        $_POST['id'],
        $nom,
        $prix,
        $idFamille,
        $image
    );

    if ($ok) {
        header('Location: admin_produits.php?msg=Produit mis à jour avec succès');
        exit();
    } else {
        $message = "Erreur lors de la mise à jour du produit.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier Produit - Supermarché 2.0</title>
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
        <div class="titre-2">Modifier le produit #<?= $produit->IdProduit ?></div>

        <div class="edit-wrapper">
            <?php if($message): ?>
                <p style="color: #ef5350; text-align: center; margin-bottom: 20px; font-weight: 600;"><?= $message ?></p>
            <?php endif; ?>

            <form method="POST">
                <input type="hidden" name="id" value="<?= $produit->IdProduit ?>">
                
                <div class="form-grid">
                    <div class="input-group">
                        <label>Nom du Produit</label>
                        <input type="text" name="nom" value="<?= htmlspecialchars($produit->NomProd) ?>" required <?= !$can_manage_catalog ? 'readonly style="opacity: 0.6; cursor: not-allowed;"' : '' ?>>
                    </div>
                    
                    <div class="input-group">
                        <label>Prix (en €)</label>
                        <input type="number" step="0.01" name="prix" value="<?= $produit->Prix ?>" required <?= !$can_edit_prices ? 'readonly style="opacity: 0.6; cursor: not-allowed;"' : '' ?>>
                    </div>
                    
                    <div class="input-group">
                        <label>Rayon (Famille)</label>
                        <select name="idFamille" required <?= !$can_manage_catalog ? 'disabled style="opacity: 0.6; cursor: not-allowed;"' : '' ?>>
                            <?php foreach ($familles as $f): ?>
                                <option value="<?= $f->IdFamille ?>" <?= ($f->IdFamille == $produit->IdFamille) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($f->NomFamille) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <?php if(!$can_manage_catalog): ?>
                             <!-- On ajoute un champ caché car un <select disabled> n'est pas envoyé en POST -->
                             <input type="hidden" name="idFamille" value="<?= $produit->IdFamille ?>">
                        <?php endif; ?>
                    </div>

                    <div class="input-group">
                        <label>Nom de l'Image</label>
                        <input type="text" name="image" value="<?= htmlspecialchars($produit->Image) ?>" placeholder="Ex: image.png" <?= !$can_manage_catalog ? 'readonly style="opacity: 0.6; cursor: not-allowed;"' : '' ?>>
                    </div>
                </div>

                <div class="zone-boutons" style="margin-top: 30px; gap: 20px;">
                    <a href="admin_produits.php" class="btn-carre" style="color: black; background: #94a3b8; border: none;">Annuler</a>
                    <button type="submit" class="btn-carre" style="background: var(--primary); color: white; border: none;">Sauvegarder les modifications</button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>
