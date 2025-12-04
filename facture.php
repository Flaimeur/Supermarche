<?php
// 1. Démarrage session
session_start();

require_once 'php/Modele.php';
$modele = new Modele();

// 2. Init Panier
if (!isset($_SESSION['panier'])) {
    $_SESSION['panier'] = [];
}

// 3. Suppression (Annuler commande / Annuler produit)
if (isset($_GET['action']) && $_GET['action'] === 'vider') {
    $_SESSION['panier'] = [];
    header("Location: facture.php");
    exit();
}
if (isset($_POST['action_suppression']) && isset($_POST['selection_produit'])) {
    $idASupprimer = $_POST['selection_produit'];
    unset($_SESSION['panier'][$idASupprimer]);
    header("Location: facture.php");
    exit();
}

// 4. Ajout produit (depuis quantite.php)
if (isset($_GET['produit']) && isset($_GET['quantite'])) {
    $id = $_GET['produit'];
    $qty = (int)$_GET['quantite'];
    
    if (isset($_SESSION['panier'][$id])) {
        $_SESSION['panier'][$id] += $qty;
    } else {
        $_SESSION['panier'][$id] = $qty;
    }
    header("Location: facture.php");
    exit();
}

// --- LOGIQUE POUR LE BOUTON "AUTRE PRODUIT" ---
// Par défaut, si le panier est vide, on retourne au choix des familles
$lienAutreProduit = "Passer_commande.php";

// Si le panier n'est pas vide, on cherche la famille du dernier produit
if (!empty($_SESSION['panier'])) {
    // On récupère les ID des produits du panier
    $idsProduits = array_keys($_SESSION['panier']);
    // On prend le dernier ID ajouté (ou le dernier de la liste)
    $dernierId = end($idsProduits);
    
    // On récupère ses infos
    $dernierProduit = $modele->getProduit($dernierId);
    
    // Si on a trouvé le produit, on crée le lien vers sa famille
    if ($dernierProduit) {
        $lienAutreProduit = "produits.php?famille=" . $dernierProduit->IdFamille;
    }
}

$totalGlobalHT = 0;

// Infos fictives
$dateFacture = date("d/m/Y");
$numFacture  = 4389; 
$numClient   = 983;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Facture</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .col-radio { width: 40px; text-align: center; border-bottom: none; }
        button.btn-carre { font-family: inherit; }
    </style>
</head>
<body>

    <div class="facture-container">
        
        <div class="header-box title">Bienvenue au supermarché 2.0</div>
        <div class="header-box subtitle">Facture :</div>

        <div class="info-grid">
            <div class="col-gauche">
                <div class="input-row">
                    <label>Numéro facture :</label>
                    <input type="text" value="<?= $numFacture ?>" readonly>
                </div>
                <div class="input-row">
                    <label>Numéro client :</label>
                    <input type="text" value="<?= $numClient ?>" readonly>
                </div>
                <div class="input-row">
                    <label>Point client :</label>
                    <input type="text" value="120" readonly>
                </div>
                <div style="height: 10px;"></div>
                <div class="input-row">
                    <label>Date facture :</label>
                    <input type="text" value="<?= $dateFacture ?>" readonly>
                </div>
            </div>

            <div class="col-centre">Facture</div>

            <div class="col-droite">
                Supermarché 2.0<br>
                10 truc Much<br>
                667 MOMO
            </div>
        </div>

        <form method="POST" action="facture.php">
            <table class="table-filaire">
                <thead>
                    <tr>
                        <th style="width: 5%;">Choix</th>
                        <th style="width: 45%;">Nom du produit</th>
                        <th style="width: 25%;">Quantité</th>
                        <th style="width: 25%;">Prix HT</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    if (!empty($_SESSION['panier'])):
                        foreach ($_SESSION['panier'] as $idProd => $qtePanier): 
                            $prodInfo = $modele->getProduit($idProd);
                            if ($prodInfo):
                                $prixLigne = $prodInfo->Prix * $qtePanier;
                                $totalGlobalHT += $prixLigne;
                    ?>
                            <tr>
                                <td class="col-radio">
                                    <input type="radio" name="selection_produit" value="<?= $idProd ?>">
                                </td>
                                <td style="text-align: center; border-bottom: none;">
                                    <?= htmlspecialchars($prodInfo->NomProd) ?>
                                </td>
                                <td style="text-align: center; border-bottom: none;">
                                    <?= $qtePanier ?>
                                </td>
                                <td style="text-align: center; border-bottom: none;">
                                    <?= number_format($prixLigne, 2) ?> €
                                </td>
                            </tr>
                    <?php 
                            endif;
                        endforeach;
                    else: 
                    ?>
                        <tr><td colspan="4" style="text-align:center; padding:10px; border:none;">Panier vide</td></tr>
                    <?php endif; ?>
                    
                    <tr>
                        <td class="vide-hauteur" style="border-top: none;"></td>
                        <td class="vide-hauteur" style="border-top: none;"></td>
                        <td class="vide-hauteur" style="border-top: none;"></td>
                        <td class="vide-hauteur" style="border-top: none;"></td>
                    </tr>
                </tbody>
            </table>

            <?php
            $montantTVA   = $totalGlobalHT * 0.20;
            $prixTotalTTC = $totalGlobalHT + $montantTVA;
            ?>

            <div class="totaux-grid">
                <div class="total-row">
                    <label>Total Hors taxes</label>
                    <input type="text" value="<?= number_format($totalGlobalHT, 2) ?> €" readonly>
                </div>
                <div class="total-row">
                    <label>T V A</label>
                    <input type="text" value="<?= number_format($montantTVA, 2) ?> €" readonly>
                </div>
                <div class="total-row">
                    <label>Total TTC</label>
                    <input type="text" value="<?= number_format($prixTotalTTC, 2) ?> €" readonly>
                </div>
            </div>

            <p style="text-align: center; margin-bottom: 20px;">
                Le supermarché Trouvetout vous remercie et vous souhaite bonne journée
            </p>

            <div class="boutons-grid-filaire">
                
                <a href="<?= $lienAutreProduit ?>" class="btn-carre">
                    Autre<br>Produit
                </a>
                
                <a href="Passer_commande.php" class="btn-carre">
                    Autre<br>Famille
                </a>
                
                <a href="facture.php?action=vider" class="btn-carre" style="color: black;">
                    Annuler la<br>commande
                </a>
                
                <button type="submit" name="action_suppression" value="1" class="btn-carre">
                    Annuler le<br>produit
                </button>
                
                <button type="button" onclick="window.print()" class="btn-carre" style="font-weight: bold;">
                    Valider<br>Imprimer
                </button>
            </div>

        </form>

    </div>

</body>
</html>