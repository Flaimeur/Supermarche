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

        <div class="container">
            <div class="titre-1">Bienvenue au supermarché 2.0</div>
            <div class="titre-2">Choix de la quantité de produit sélectionné</div>

            <div class="produit-info">
                <h3 style="margin: 0; color: #3498db;"><?= htmlspecialchars($produit->NomProd) ?></h3>

                <div class="image-box">Image du produit</div>

                <div class="info-ligne">
                    <span>Prix unitaire :</span>
                    <strong><?= $produit->Prix ?> €</strong>
                </div>

                <div class="info-ligne">
                    <label for="qty">Quantité :</label>
                    <input type="number" id="qty" name="quantite" value="1" min="1" required>
                </div>
            </div>

            <div class="zone-boutons">
                <a href="produits.php?famille=<?= $produit->IdFamille ?>" class="bouton-menu">Retour</a>
                <button type="submit" class="bouton-menu btn-blue">Valider</button>
                <button type="reset" class="bouton-menu btn-danger">Annuler</button>
            </div>
        </div>
    </form>
</body>
</html>