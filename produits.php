<?php
require_once 'php/Modele.php';
$idFamille = isset($_GET['famille']) ? $_GET['famille'] : 0;
$modele = new Modele();
$produits = $modele->getProduitsParFamille($idFamille);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Choix du produit</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .selection-wrapper {
            display: flex;
            gap: 20px;
            align-items: flex-start;
        }
        #preview-img {
            width: 150px;
            height: 150px;
            object-fit: contain;
            border: 1px solid #ccc;
            background-color: #f9f9f9;
            border-radius: 8px;
            display: none; /* Caché au début */
        }
    </style>
</head>
<body>

    <form action="quantite.php" method="GET">
        
        <div class="container">
            <div class="titre-1">Bienvenue au supermarché 2.0</div>
            <div class="titre-2">Choix du produit</div>

            <div class="selection-wrapper">
                
                <select id="listeProduits" name="produit" size="15" required style="flex: 1;">
                    <?php if(count($produits) > 0): ?>
                        <?php foreach ($produits as $p): ?>
                            <?php $img = !empty($p->Image) ? $p->Image : 'default.png'; ?>
                            
                            <option value="<?= $p->IdProduit ?>" data-img="<?= $img ?>">
                                <?= htmlspecialchars($p->NomProd) ?> - <?= $p->Prix ?> €
                            </option>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <option disabled>Aucun produit ici</option>
                    <?php endif; ?>
                </select>

                <img id="preview-img" src="" alt="Aperçu produit">
                
            </div>

            <div class="zone-boutons">
                <a href="Passer_commande.php" class="bouton-menu">Retour</a>
                <button type="submit" class="bouton-menu btn-blue">Valider</button>
                <button type="reset" class="bouton-menu btn-danger">Annuler</button>
            </div>
        </div>

    </form>

    <script>
        const select = document.getElementById('listeProduits');
        const img = document.getElementById('preview-img');

        select.addEventListener('change', function() {
            // On récupère l'option sélectionnée
            const option = select.options[select.selectedIndex];
            
            // On récupère le nom de l'image stocké dans data-img
            const imageFile = option.getAttribute('data-img');
            
            // 3. On met à jour la source de l'image
            if (imageFile) {
                img.src = "img/" + imageFile; 
                img.style.display = "block";  
            }
        });
    </script>

</body>
</html>