        <div class="titre-1">SUPERMARCHÉ 2.0</div>
        <div class="titre-2">Récupération de compte</div>

        <p style="text-align: center; color: var(--text-dim); margin-bottom: 30px;">
            Veuillez saisir votre numéro client et votre mot magique pour réinitialiser votre mot de passe.
        </p>

        <?php if(isset($error) && $error): ?>
            <p style="color: #ef5350; font-weight: bold; margin-bottom: 20px; text-align: center;"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <form method="POST" action="index.php?action=forgot_password_post">
            <div class="input-row">
                <label>Numéro Client</label>
                <input type="text" name="num_client" required placeholder="Ex: 123">
            </div>

            <div class="input-row">
                <label>Votre Mot Magique</label>
                <input type="text" name="mot_magique" required placeholder="Le mot choisi à l'inscription">
            </div>

            <div class="zone-boutons" style="margin-top: 30px;">
                <a href="index.php?action=login" class="bouton-menu">Retour</a>
                <button type="submit" class="bouton-menu btn-blue">Vérifier</button>
            </div>
        </form>
