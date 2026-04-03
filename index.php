<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supermarché 2.0</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <!-- Animation de lancement PRO-GRADE V2 (Centrée & Polie) -->
    <div id="splash-screen">
        <!-- Lignes de vitesse pro -->
        <div class="speed-line" style="top: 15%; animation-delay: 0.1s;"></div>
        <div class="speed-line" style="top: 45%; animation-delay: 0.3s; width: 400px;"></div>
        <div class="speed-line" style="top: 75%; animation-delay: 0.2s;"></div>
        
        <h1 class="brand-reveal">Supermarché 2.0</h1>
        
        <div class="cart-container">
            <div class="cart-wrapper">
                <div class="cart-icon">🛒</div>
            </div>
            <div class="ground"></div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const splash = document.getElementById('splash-screen');
            
            if (sessionStorage.getItem('splashPlayed')) {
                splash.style.display = 'none';
            } else {
                // Animation pro : 5.5s de trajet + fondu
                setTimeout(() => {
                    splash.classList.add('hidden');
                    sessionStorage.setItem('splashPlayed', 'true');
                    
                    setTimeout(() => {
                        splash.remove();
                    }, 1500); // Plus lent fondu pour le "Pro"
                }, 5500); 
            }
        });
    </script>

    <div class="container">

        <div class="titre-1">
            <?php if(isset($_SESSION['client'])): ?>
                Ravi de vous revoir, <?= htmlspecialchars($_SESSION['client']->Prenom) ?> !
            <?php else: ?>
                Bienvenue dans notre supermarché
            <?php endif; ?>
        </div>
        <div class="titre-2">Tableau de bord</div>

        <div class="nav-grid">
            <a href="Passer_commande.php" class="nav-card accent">
                <div class="emoji">🚀</div>
                <span>Passer une commande</span>
            </a>
            
            <?php if(isset($_SESSION['client'])): ?>
                <a href="logout.php" class="nav-card danger">
                    <div class="emoji">🚪</div>
                    <span>Se déconnecter</span>
                </a>
            <?php else: ?>
                <a href="login.php" class="nav-card success">
                    <div class="emoji">🔐</div>
                    <span>Se connecter</span>
                </a>
            <?php endif; ?>
            
            <a href="inscription.php" class="nav-card">
                <div class="emoji">🆔</div>
                <span>Carte Fidélité / Inscription</span>
            </a>
            
            <?php if(isset($_SESSION['client'])): ?>
                <?php $role = $_SESSION['client']->role; ?>
                
                <?php if($role === 'super_admin' || $role === 'admin_comptes'): ?>
                    <a href="admin_gestion.php" class="nav-card">
                        <div class="emoji">👥</div>
                        <span>Gestion Comptes</span>
                    </a>
                <?php endif; ?>

                <?php if($role === 'super_admin' || $role === 'admin_produits' || $role === 'admin_prix'): ?>
                    <a href="admin_produits.php" class="nav-card">
                        <div class="emoji">📦</div>
                        <span>Gestion Produits</span>
                    </a>
                <?php endif; ?>
            <?php endif; ?>
        </div>

    </div>
    
</body>
</html>