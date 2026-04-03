    <style>
        .edit-wrapper {
            max-width: 600px;
            margin: 30px auto;
            background: rgba(0, 0, 0, 0.2);
            border: 1px solid var(--glass-border);
            padding: 40px;
            border-radius: 20px;
            backdrop-filter: blur(12px);
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 20px;
        }

        .input-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .input-group label {
            color: var(--primary);
            font-weight: 700;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .input-group input, .input-group select {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--glass-border);
            padding: 12px;
            border-radius: 10px;
            color: #fff;
            outline: none;
            transition: var(--transition);
        }

        .input-group input:focus, .input-group select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 10px var(--primary-glow);
            background: rgba(255, 255, 255, 0.1);
        }
    </style>

    <div class="titre-1">Administration</div>
    <div class="titre-2">Modifier le produit #<?= $produit->IdProduit ?></div>

    <div class="edit-wrapper">
        <?php if(isset($message) && $message): ?>
            <p style="color: #ef5350; text-align: center; margin-bottom: 20px; font-weight: 600;"><?= $message ?></p>
        <?php endif; ?>

        <form method="POST" action="index.php?action=edit_produit&id=<?= $produit->IdProduit ?>">
            <input type="hidden" name="id" value="<?= $produit->IdProduit ?>">
            
            <div class="form-grid">
                <div class="input-group">
                    <label>Nom du Produit</label>
                    <input type="text" name="nom" value="<?= htmlspecialchars($produit->NomProd) ?>" required <?= !$can_manage_catalog ? 'readonly style="opacity: 0.6; cursor: not-allowed;"' : '' ?>>
                </div>
                
                <div class="input-group">
                    <label>Prix (en €)</label>
                    <input type="number" step="0.01" name="prix" value="<?= $produit->Prix ?>" required <?= !$can_edit_prices ? 'readonly style="opacity: 0.6; cursor: not-allowed;"' : '' ?>>
                </div>
                
                <div class="input-group">
                    <label>Rayon (Famille)</label>
                    <select name="idFamille" required <?= !$can_manage_catalog ? 'disabled style="opacity: 0.6; cursor: not-allowed;"' : '' ?>>
                        <?php foreach ($familles as $f): ?>
                            <option value="<?= $f->IdFamille ?>" <?= ($f->IdFamille == $produit->IdFamille) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($f->NomFamille) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php if(!$can_manage_catalog): ?>
                         <input type="hidden" name="idFamille" value="<?= $produit->IdFamille ?>">
                    <?php endif; ?>
                </div>

                <div class="input-group">
                    <label>Nom de l'Image</label>
                    <input type="text" name="image" value="<?= htmlspecialchars($produit->Image) ?>" placeholder="Ex: image.png" <?= !$can_manage_catalog ? 'readonly style="opacity: 0.6; cursor: not-allowed;"' : '' ?>>
                </div>
            </div>

            <div class="zone-boutons" style="margin-top: 30px; gap: 20px;">
                <a href="index.php?action=admin_inventaire" class="btn-carre" style="color: black; background: #94a3b8; border: none;">Annuler</a>
                <button type="submit" class="btn-carre" style="background: var(--primary); color: white; border: none;">Sauvegarder les modifications</button>
            </div>
        </form>
    </div>
