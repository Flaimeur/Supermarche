<?php
require_once 'php/Modele.php';

// On récupère l'ID du produit depuis l'URL (venant de produits.php)
$idProduit = isset($_GET['produit']) ? $_GET['produit'] : 0;

$modele = new Modele();
$produit = $modele->getProduit($idProduit);

if (!$produit) {
    header('Location: produits.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Quantité - Supermarché</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <form action="facture.php" method="GET">
        
        <input type="hidden" name="produit" value="<?= $produit->IdProduit ?>">

        <div class="container" style="max-width: 650px;">
            <div class="titre-1">Panier</div>
            <div class="titre-2">Veuillez indiquer la quantité souhaitée</div>

            <div style="background: rgba(0,0,0,0.25); border: 1px solid var(--glass-border); border-radius: 20px; padding: 40px 30px; margin-bottom: 30px; display: flex; flex-direction: column; align-items: center; gap: 20px; box-shadow: inset 0 0 30px rgba(0,0,0,0.4);">
                
                <h3 style="margin: 0; color: var(--text-main); font-size: 2rem; font-weight: 800; text-align: center; text-transform: uppercase; letter-spacing: 0.05em; text-shadow: 0 2px 10px rgba(0,0,0,0.5);"><?= htmlspecialchars($produit->NomProd) ?></h3>

                <?php $imageSrc = !empty($produit->Image) ? "img/" . $produit->Image : "img/default.png"; ?>

                <div style="background: rgba(255,255,255,0.03); padding: 25px; border-radius: 20px; width: 220px; height: 220px; display: flex; justify-content: center; align-items: center; border: 1px solid rgba(255,255,255,0.05);">
                    <img src="<?= $imageSrc ?>" alt="<?= htmlspecialchars($produit->NomProd) ?>" style="max-width:100%; max-height:100%; object-fit: contain; filter: drop-shadow(0 15px 25px rgba(0,0,0,0.6)); transition: transform 0.3s;" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'" onerror="this.src='img/default.png'">
                </div>
                
                <div style="display: flex; flex-direction: column; align-items: center; gap: 5px;">
                    <div style="font-size: 1.8rem; font-weight: 900; color: #f1c40f; background: rgba(241, 196, 15, 0.1); padding: 8px 25px; border-radius: 30px; border: 1px solid rgba(241, 196, 15, 0.3); box-shadow: 0 0 20px rgba(241, 196, 15, 0.15);">
                        <?= number_format($produit->Prix, 2) ?> € <span style="font-size: 1.1rem; color: var(--text-dim); font-weight: 500;">/ l'unité</span>
                    </div>
                </div>

                <div style="width: 80%; height: 1px; background: linear-gradient(90deg, transparent, var(--glass-border), transparent); margin: 15px 0;"></div>

                <div style="display: flex; align-items: center; gap: 20px; width: 100%; justify-content: center;">
                    <label for="qty" style="font-weight: 700; color: var(--primary); font-size: 1.2rem; text-transform: uppercase; letter-spacing: 0.1em;">Quantité</label>
                    <input type="number" id="qty" name="quantite" value="1" min="1" max="99" required style="width: 120px; text-align: center; font-size: 1.5rem; font-weight: 900; background: rgba(255,255,255,0.08); border: 2px solid var(--primary); color: white; border-radius: 12px; padding: 10px;">
                </div>
            </div>

            <div class="zone-boutons" style="justify-content: space-between; gap: 20px;">
                <a href="produits.php?famille=<?= $produit->IdFamille ?>" class="btn-carre" style="background: rgba(255,255,255,0.05); border: 1px solid var(--glass-border);">Annuler</a>
                <button type="submit" class="btn-carre btn-blue" style="font-size: 1.1rem;">🛒 Ajouter au panier</button>
            </div>
        </div>
    </form>
</body>
</html>