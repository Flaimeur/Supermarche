<?php
require_once 'php/db.php'; 

try {
    $sql = "SELECT * FROM famille"; 
    $sth = $dbh->query($sql);
    $familles = $sth->fetchAll(PDO::FETCH_OBJ);
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Choix de la famille</title>
    <style>
        body { text-align: center; font-family: sans-serif; }
        .container { border: 1px solid #000; display: inline-block; padding: 20px; margin-top: 20px; width: 400px; }
        select { width: 80%; height: 150px; margin: 20px 0; font-size: 1.1em; } /* Style Listbox [cite: 11] */
        .actions { display: flex; justify-content: space-between; }
        button { padding: 10px 20px; cursor: pointer; }
    </style>
</head>
<body>

    <div class="container">
        <h3>Bienvenue au supermarché 2.0</h3> <h4>Choix de la famille de produits</h4> <form action="produits.php" method="GET">
            
            <select name="famille_id" size="5" required>
                <?php foreach ($familles as $famille): ?>
                    <option value="<?= $famille->idFamille ?>">
                        <?= htmlspecialchars($famille->LibelleFamille) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <div class="actions">
                <a href="index.php"><button type="button">Retour</button></a>
                
                <button type="submit">Valider</button>
                
                <button type="reset">Annuler</button>
            </div>
        </form>
    </div>

</body>
</html>