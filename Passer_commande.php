<?php
require_once 'php/Modele.php';
$modele = new Modele();
$familles = $modele->getFamilles();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Choix de la famille</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <div class="container" style="max-width: 900px;">
        <div class="titre-1">Rayons</div>
        <div class="titre-2">Choisissez une catégorie de produits</div>

        <div class="nav-grid">
            <?php foreach ($familles as $f): 
                $emoji = "🛒";
                $nom = strtolower(trim($f->NomFamille));
                if(strpos($nom, 'boisson') !== false) $emoji = "🥤";
                elseif(strpos($nom, 'légume') !== false || strpos($nom, 'legume') !== false) $emoji = "🥦";
                elseif(strpos($nom, 'fruit') !== false) $emoji = "🍎";
                elseif(strpos($nom, 'boulangerie') !== false || strpos($nom, 'pain') !== false) $emoji = "🥖";
                elseif(strpos($nom, 'viande') !== false || strpos($nom, 'boucherie') !== false) $emoji = "🥩";
                elseif(strpos($nom, 'poisson') !== false) $emoji = "🐟";
                elseif(strpos($nom, 'lait') !== false || strpos($nom, 'fromage') !== false) $emoji = "🧀";
                elseif(strpos($nom, 'hygiène') !== false || strpos($nom, 'beaute') !== false) $emoji = "🧼";
            ?>
            <a href="produits.php?famille=<?= $f->IdFamille ?>" class="nav-card accent" style="padding: 40px 20px;">
                <div class="emoji" style="font-size: 4rem;"><?= $emoji ?></div>
                <span style="font-size: 1.3rem; text-transform: uppercase; letter-spacing: 0.05em;"><?= htmlspecialchars($f->NomFamille) ?></span>
            </a>
            <?php endforeach; ?>
        </div>

        <div class="zone-boutons" style="justify-content: center; margin-top: 40px;">
            <a href="index.php" class="btn-carre" style="max-width: 250px; background: rgba(255,255,255,0.05); border: 1px solid var(--glass-border);">🏠 Retour au Dashboard</a>
        </div>
    </div>

</body>
</html>