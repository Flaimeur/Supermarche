        <div class="titre-1">SUPERMARCHÉ 2.0</div>
        <div class="titre-2">Nouveau Mot de Passe</div>

        <p style="text-align: center; color: var(--text-dim); margin-bottom: 30px;">
            Identité vérifiée. Saisissez votre nouveau mot de passe.
        </p>

        <?php if(isset($error) && $error): ?>
            <p style="color: #ef5350; font-weight: bold; margin-bottom: 20px; text-align: center;"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <form method="POST" action="index.php?action=reset_password_post">
            <div class="input-row">
                <label>Nouveau MDP</label>
                <input type="password" name="mdp" required>
            </div>

            <div class="input-row">
                <label>Confirmer MDP</label>
                <input type="password" name="confirm_mdp" required>
            </div>

            <div class="zone-boutons" style="margin-top: 30px;">
                <button type="submit" class="bouton-menu btn-blue">Changer le mot de passe</button>
            </div>
        </form>
