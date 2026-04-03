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
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .full-width {
            grid-column: span 2;
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

        .input-group input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 10px var(--primary-glow);
            background: rgba(255, 255, 255, 0.1);
        }
    </style>

    <div class="titre-1">Administration</div>
    <div class="titre-2">Modifier l'utilisateur #<?= $client->IdClient ?></div>

    <div class="edit-wrapper">
        <?php if(isset($message) && $message): ?>
            <p style="color: #ef5350; text-align: center; margin-bottom: 20px;"><?= $message ?></p>
        <?php endif; ?>

        <form method="POST" action="index.php?action=edit_client&id=<?= $client->IdClient ?>">
            <input type="hidden" name="id" value="<?= $client->IdClient ?>">
            
            <div class="form-grid">
                <div class="input-group">
                    <label>Nom</label>
                    <input type="text" name="nom" value="<?= htmlspecialchars($client->Nom) ?>" required>
                </div>
                <div class="input-group">
                    <label>Prénom</label>
                    <input type="text" name="prenom" value="<?= htmlspecialchars($client->Prenom) ?>" required>
                </div>
                <div class="input-group full-width">
                    <label>Adresse</label>
                    <input type="text" name="adresse" value="<?= htmlspecialchars($client->Adresse) ?>" required>
                </div>
                <div class="input-group">
                    <label>Ville</label>
                    <input type="text" name="ville" value="<?= htmlspecialchars($client->Ville) ?>" required>
                </div>
                <div class="input-group">
                    <label>Code Postal</label>
                    <input type="text" name="cp" value="<?= htmlspecialchars($client->CodePostal) ?>" required>
                </div>
                <div class="input-group">
                    <label>Points Fidélité</label>
                    <input type="number" name="point" value="<?= $client->point ?>" required>
                </div>

                <div class="input-group full-width">
                    <label>Rôle de l'utilisateur</label>
                    <select name="role" required style="background: rgba(52, 152, 219, 0.1); border: 1px solid rgba(52, 152, 219, 0.2); color: var(--primary); font-weight: 700;">
                        <option value="client" <?= $client->role === 'client' ? 'selected' : '' ?>>👤 Client Standard</option>
                        <option value="admin_produits" <?= $client->role === 'admin_produits' ? 'selected' : '' ?>>📦 Admin Articles (Ajout)</option>
                        <option value="admin_prix" <?= $client->role === 'admin_prix' ? 'selected' : '' ?>>🏷️ Admin Prix (Edition)</option>
                        <option value="admin_suppression" <?= $client->role === 'admin_suppression' ? 'selected' : '' ?>>🗑️ Admin Suppression</option>
                        <option value="admin_comptes" <?= $client->role === 'admin_comptes' ? 'selected' : '' ?>>👥 Admin Comptes Clients</option>
                        <option value="super_admin" <?= $client->role === 'super_admin' ? 'selected' : '' ?>>👑 Super Administrateur</option>
                    </select>
                </div>
            </div>

            <div class="zone-boutons" style="margin-top: 30px; gap: 20px;">
                <a href="index.php?action=admin_membres" class="btn-carre" style="color: black; background: #94a3b8; border: none;">Annuler</a>
                <button type="submit" class="btn-carre" style="background: var(--primary); color: white; border: none;">Sauvegarder</button>
            </div>
        </form>
    </div>
