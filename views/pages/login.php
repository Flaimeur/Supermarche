        <div class="titre-1">SUPERMARCHÉ 2.0</div>
        <div class="titre-2">Espace Client</div>

        <?php if($message): ?>
            <p style="color: #ef5350; font-weight: bold; margin-bottom: 20px;"><?= htmlspecialchars($message) ?></p>
        <?php endif; ?>

        <form method="POST" action="index.php?action=login_post">
            <div class="input-row">
                <label>Numéro Client</label>
                <input type="text" name="num_client" required placeholder="Ex: 123">
            </div>

            <div class="input-row">
                <label>Mot de passe</label>
                <input type="password" name="mdp" required>
            </div>

            <div class="zone-boutons">
                <a href="index.php" class="bouton-menu">Retour</a>
                <button type="submit" class="bouton-menu btn-blue">Se connecter</button>
            </div>
        </form>

        <p style="margin-top: 30px; color: var(--text-dim);">
            <a href="index.php?action=forgot_password" style="color: var(--primary); text-decoration: none; font-weight: 600; display: block; margin-bottom: 10px;">Mot de passe oublié ?</a>
            Pas encore de compte ? <a href="index.php?action=inscription" style="color: var(--primary); text-decoration: none;">Inscrivez-vous ici</a>
        </p>
