    <style>
        .product-img {
            width: 120px;
            height: 120px;
            object-fit: contain;
            margin-bottom: 15px;
            border-radius: 12px;
            background: rgba(255,255,255,0.05);
            padding: 10px;
            transition: var(--transition);
        }
        
        .nav-card:hover .product-img {
            transform: scale(1.1) translateY(-5px);
            filter: drop-shadow(0 10px 15px rgba(0,0,0,0.5));
        }
        
        .product-title {
            font-weight: 700;
            font-size: 1.15rem;
            text-align: center;
            margin-bottom: 5px;
            color: var(--text-main);
        }

        .product-price {
            color: #f1c40f;
            font-weight: 900;
            font-size: 1.25rem;
            background: rgba(241, 196, 15, 0.1);
            padding: 4px 12px;
            border-radius: 20px;
            border: 1px solid rgba(241, 196, 15, 0.3);
        }
    </style>

    <div class="titre-1">Nos Produits</div>
    <div class="titre-2">Sélectionnez l'article de votre choix</div>

    <div class="nav-grid">
        <?php if(count($produits) > 0): ?>
            <?php foreach ($produits as $p): ?>
                <?php $img = !empty($p->Image) ? $p->Image : 'default.png'; ?>
                
                <a href="index.php?action=quantite&id=<?= $p->IdProduit ?>" class="nav-card" style="padding: 30px 20px;">
                    <img src="img/<?= htmlspecialchars($img) ?>" class="product-img" alt="<?= htmlspecialchars($p->NomProd) ?>" onerror="this.src='img/default.png'">
                    <span class="product-title"><?= htmlspecialchars($p->NomProd) ?></span>
                    <span class="product-price"><?= number_format($p->Prix, 2) ?> €</span>
                </a>
            <?php endforeach; ?>
        <?php else: ?>
            <div style="grid-column: 1 / -1; text-align: center; padding: 40px; background: rgba(255,255,255,0.05); border-radius: 20px;">
                <span style="font-size: 3rem; display: block; margin-bottom: 10px;">🛒</span>
                <p style="color: var(--text-dim); font-size: 1.2rem;">Aucun produit disponible dans ce rayon pour le moment.</p>
            </div>
        <?php endif; ?>
    </div>

    <div class="zone-boutons" style="justify-content: center; margin-top: 40px;">
        <a href="index.php?action=rayons" class="btn-carre" style="max-width: 250px; background: rgba(255,255,255,0.05); border: 1px solid var(--glass-border);">⬅️ Retour aux rayons</a>
    </div>
