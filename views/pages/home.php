<!-- Architecture MVC : Intégration de l'animation Splash dans la vue HOME -->
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
                }, 1500); 
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
        <a href="index.php?action=rayons" class="nav-card accent">
            <div class="emoji">🚀</div>
            <span>Passer une commande</span>
        </a>
        
        <?php if(isset($_SESSION['client'])): ?>
            <a href="index.php?action=logout" class="nav-card danger">
                <div class="emoji">🚪</div>
                <span>Se déconnecter</span>
            </a>
        <?php else: ?>
            <a href="index.php?action=login" class="nav-card success">
                <div class="emoji">🔐</div>
                <span>Se connecter</span>
            </a>
        <?php endif; ?>
        
        <a href="index.php?action=inscription" class="nav-card">
            <div class="emoji">🆔</div>
            <span>Carte Fidélité / Inscription</span>
        </a>
        
        <?php if(isset($_SESSION['client']) && $_SESSION['client']->role !== 'client'): ?>
            <?php 
                $admin_route = "admin_membres";
                if (in_array($_SESSION['client']->role, ['admin_produits', 'admin_prix', 'admin_suppression'])) {
                    $admin_route = "admin_inventaire";
                }
            ?>
            <a href="index.php?action=<?= $admin_route ?>" class="nav-card">
                <div class="emoji">⚙️</div>
                <span>Gestion BD</span>
            </a>
        <?php endif; ?>
    </div>
</div>
