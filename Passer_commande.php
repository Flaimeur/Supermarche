<?php
require_once 'php/db.php';

try {
    $sql = "SELECT * FROM famille"; 
    $sth = $dbh->query($sql);
    $familles = $sth->fetchAll(PDO::FETCH_OBJ);
} catch (PDOException $e) {
    die("Erreur SQL : " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Choix de la famille</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <form action="produits.php" method="GET">
        
        <div class="container">
            <div class="titre-1">Bienvenue au supermarché 2.0</div>
            <div class="titre-2">Choix de la famille de produits</div>

            <select name="famille" size="5" required>
                <?php foreach ($familles as $f): ?>
                    <option value="<?= $f->IdFamille ?>">
                        <?= htmlspecialchars($f->NomFamille) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <div class="zone-boutons">
                
                <a href="index.php" class="bouton-menu">Retour</a>

                <button type="submit" class="bouton-menu">Valider</button>
                
                <button type="reset" class="bouton-menu btn-danger">Annuler</button>
                
            </div>

        </div>
        
    </form> 
</body>
</html>