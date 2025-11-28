<?php
require_once 'php/db.php';

$idFamille = isset($_GET['famille']) ? $_GET['famille'] : 0;

try {
    $sql = "SELECT * FROM produit WHERE IdFamille = :id";
    $sth = $dbh->prepare($sql);
    $sth->execute(['id' => $idFamille]);
    $produits = $sth->fetchAll(PDO::FETCH_OBJ);
} catch (PDOException $e) {
    die("Erreur SQL : " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Choix du produit</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <form action="panier.php" method="GET">
        
        <div class="container">
            <div class="titre-1">Bienvenue au supermarché 2.0</div>
            <div class="titre-2">Choix du produit</div>

            <select name="produit" size="5" required>
                <?php if(count($produits) > 0): ?>
                    <?php foreach ($produits as $p): ?>
                        <option value="<?= $p->IdProduit ?>">
                            <?= htmlspecialchars($p->NomProd) ?> - <?= $p->Prix ?> €
                        </option>
                    <?php endforeach; ?>
                <?php else: ?>
                    <option disabled>Aucun produit ici</option>
                <?php endif; ?>
            </select>
            <div class="zone-boutons">
                <a href="Passer_commande.php" class="bouton-menu">Retour</a>

                <button type="submit" class="bouton-menu">Valider</button>
                
                <button type="reset" class="bouton-menu btn-danger">Annuler</button>
            </div>

        </div>
    </form>

</body>
</html>