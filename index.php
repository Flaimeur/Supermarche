<?php
require_once 'php/db.php'; 

try {
    $sql = 'SELECT * FROM produit'; 
    $sth = $dbh->prepare($sql);
    $sth->execute();
    $resultats = $sth->fetchAll(PDO::FETCH_OBJ);
} catch (PDOException $e) {
    echo "Erreur lors de la récupération des produits : " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Produits</title>
    <style>
        table { border-collapse: collapse; width: 50%; margin: 20px auto; }
        th, td { border: 1px solid #333; padding: 10px; text-align: center; }
        th { background-color: #f4f4f4; }
    </style>
</head>
<body>

    <h1 style="text-align:center;">Liste des produits</h1>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom du Produit</th> 
                <th>Prix</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($resultats as $row): ?>
                <tr>
                    <td><?= htmlspecialchars($row->IdProduit) ?></td>
                    <td><?= htmlspecialchars($row->NomProd) ?></td> 
                    <td><?= htmlspecialchars($row->Prix) ?> €</td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</body>
</html>