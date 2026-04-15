    <style>
        .col-radio { width: 40px; text-align: center; border-bottom: none; }
        button.btn-carre { font-family: inherit; }
    </style>

    <div class="titre-1">FACTURE</div>
    <div class="titre-2">Résumé de votre commande</div>

    <?php if (isset($isSuccess) && $isSuccess): ?>
        <div style="background: rgba(46, 204, 113, 0.2); border: 1px solid #2ecc71; border-radius: 12px; padding: 20px; margin-bottom: 30px; text-align: center; animation: slideDown 0.5s ease-out;">
            <div style="font-size: 1.5rem; color: #2ecc71; font-weight: 700; margin-bottom: 5px;">🎉 Commande Validée !</div>
            <div style="color: white; opacity: 0.9;">Votre achat a été enregistré avec succès dans notre base de données.</div>
            <div style="font-size: 0.85rem; color: #f1c40f; margin-top: 10px; font-weight: 600;">+ <?= floor($totalGlobalHT / 10) ?> points de fidélité gagnés</div>
        </div>
        
        <script>
            // Déclenchement de l'impression après un court délai pour laisser la page s'afficher
            window.onload = function() {
                setTimeout(() => {
                    window.print();
                }, 1000);
            };
        </script>
    <?php endif; ?>

    <!-- En-tête de facture -->
    <div style="display: flex; justify-content: space-between; background: rgba(0,0,0,0.2); padding: 25px; border-radius: 16px; border: 1px solid var(--glass-border); margin-bottom: 30px;">
        <div style="display: flex; flex-direction: column; gap: 8px;">
            <div style="font-size: 0.9rem; color: var(--text-dim); text-transform: uppercase;">Facture N°</div>
            <div style="font-size: 1.2rem; font-weight: 700; color: var(--primary); font-family: monospace;">#<?= str_pad($numFacture, 6, '0', STR_PAD_LEFT) ?></div>
            <div style="font-size: 0.9rem; color: var(--text-dim); text-transform: uppercase; margin-top: 10px;">Date</div>
            <div style="font-size: 1.1rem; font-weight: 600; color: white;"><?= $dateFacture ?></div>
        </div>
        
        <div style="display: flex; flex-direction: column; gap: 8px; text-align: right;">
            <div style="font-size: 0.9rem; color: var(--text-dim); text-transform: uppercase;">Client N°</div>
            <div style="font-size: 1.1rem; font-weight: 600; color: white;"><?= $numClient ?></div>
            <div style="font-size: 0.9rem; color: var(--text-dim); text-transform: uppercase; margin-top: 10px;">Points Fidélité</div>
            <div style="font-size: 1.1rem; font-weight: 700; color: #f1c40f;"><?= $pointsClient ?> pts</div>
        </div>
    </div>

    <form method="POST" action="index.php?action=facture">
        
        <!-- Tableau des articles -->
        <div style="background: rgba(255,255,255,0.03); border-radius: 16px; border: 1px solid var(--glass-border); overflow: hidden; margin-bottom: 30px;">
            <table style="width: 100%; border-collapse: collapse; text-align: left;">
                <thead style="background: rgba(52, 152, 219, 0.15); border-bottom: 1px solid var(--glass-border);">
                    <tr>
                        <th style="padding: 15px; color: var(--primary); font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.1em; width: 5%;"></th>
                        <th style="padding: 15px; color: var(--primary); font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.1em; width: 50%;">Article</th>
                        <th style="padding: 15px; color: var(--primary); font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.1em; text-align: center; width: 20%;">Qté</th>
                        <th style="padding: 15px; color: var(--primary); font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.1em; text-align: right; width: 25%;">Total HT</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($panierDetail)): ?>
                        <?php foreach ($panierDetail as $p): ?>
                            <tr style="border-bottom: 1px solid rgba(255,255,255,0.05); transition: background 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.02)'" onmouseout="this.style.background='transparent'">
                                <td style="padding: 15px; text-align: center;">
                                    <input type="radio" name="selection_produit" value="<?= $p->IdProduit ?>" style="width: 18px; height: 18px; accent-color: #e74c3c; cursor: pointer;">
                                </td>
                                <td style="padding: 15px; font-weight: 600; color: white;">
                                    <?= htmlspecialchars($p->NomProd) ?>
                                    <div style="font-size: 0.8rem; color: var(--text-dim); font-weight: 400;"><?= number_format($p->Prix, 2) ?> € / unité</div>
                                </td>
                                <td style="padding: 15px; text-align: center; font-weight: 700; color: white;">
                                    <?= $p->qte ?>
                                </td>
                                <td style="padding: 15px; text-align: right; font-weight: 700; color: #f1c40f;">
                                    <?= number_format($p->totalLigne, 2) ?> €
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="4" style="text-align:center; padding: 40px; color: var(--text-dim); font-style: italic;">Votre panier est actuellement vide.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
            
            <?php if(!empty($panierDetail)): ?>
            <div style="padding: 12px 20px; background: rgba(231, 76, 60, 0.1); border-top: 1px solid var(--glass-border); text-align: left;">
                <button type="submit" name="action_suppression" value="1" style="background: none; border: none; color: #ef5350; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 8px; font-size: 0.9rem; transition: 0.2s;" onmouseover="this.style.color='#ff7979'" onmouseout="this.style.color='#ef5350'">
                    🗑️ Retirer l'article sélectionné
                </button>
            </div>
            <?php endif; ?>
        </div>

        <?php
        $montantTVA   = $totalGlobalHT * 0.20;
        $prixTotalTTC = $totalGlobalHT + $montantTVA;
        ?>

        <!-- Résumé des totaux -->
        <div style="display: flex; justify-content: flex-end; margin-bottom: 40px;">
            <div style="background: rgba(0,0,0,0.3); border: 1px solid var(--glass-border); border-radius: 16px; padding: 25px; min-width: 300px;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 12px; color: var(--text-dim); font-weight: 500;">
                    <span>Total HT</span>
                    <span><?= number_format($totalGlobalHT, 2) ?> €</span>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 15px; color: var(--text-dim); font-weight: 500;">
                    <span>TVA (20%)</span>
                    <span><?= number_format($montantTVA, 2) ?> €</span>
                </div>
                <div style="height: 1px; background: var(--glass-border); margin-bottom: 15px;"></div>
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span style="font-size: 1.2rem; font-weight: 700; color: white;">TOTAL TTC</span>
                    <span style="font-size: 1.6rem; font-weight: 900; color: var(--primary); text-shadow: 0 0 15px var(--primary-glow);"><?= number_format($prixTotalTTC, 2) ?> €</span>
                </div>
            </div>
        </div>

        <p style="text-align: center; margin-bottom: 30px; color: var(--text-dim); font-size: 0.9rem;">
            Le supermarché <strong>Trouvetout (2.0)</strong> vous remercie de votre confiance.
        </p>

        <!-- Actions principales -->
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
            <a href="<?= $lienAutreProduit ?>" class="btn-carre" style="margin: 0; background: rgba(52, 152, 219, 0.1); border-color: rgba(52, 152, 219, 0.3); color: #3498db; display: flex; align-items: center; justify-content: center; gap: 10px;">
                🛍️ Continuer mes achats
            </a>
            <a href="index.php?action=rayons" class="btn-carre" style="margin: 0; background: rgba(255,255,255,0.05); display: flex; align-items: center; justify-content: center; gap: 10px;">
                🧭 Changer de rayon
            </a>
        </div>
        
        <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 15px;">
            <?php if (!(isset($isSuccess) && $isSuccess)): ?>
                <a href="index.php?action=facture&subaction=vider" class="btn-carre" style="margin: 0; background: rgba(231, 76, 60, 0.1); border-color: rgba(231, 76, 60, 0.3); color: #ef5350; display: flex; align-items: center; justify-content: center; gap: 10px; transition: 0.3s;" onmouseover="this.style.background='#e74c3c'; this.style.color='white'" onmouseout="this.style.background='rgba(231, 76, 60, 0.1)'; this.style.color='#ef5350'">
                    🗑️ Vider le panier
                </a>
                <button type="submit" name="action_valider" value="1" class="btn-carre btn-blue" style="margin: 0; font-size: 1.1rem; letter-spacing: 0.05em; text-transform: uppercase;">
                    ✅ Valider & Imprimer la facture
                </button>
            <?php else: ?>
                <button type="button" onclick="window.print()" class="btn-carre btn-blue" style="grid-column: span 2; margin: 0; font-size: 1.1rem; letter-spacing: 0.05em; text-transform: uppercase;">
                    🖨️ Ré-imprimer la facture
                </button>
            <?php endif; ?>
        </div>

    </form>
