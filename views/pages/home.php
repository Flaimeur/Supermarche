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
            
            <?php if(isset($_SESSION['client'])): ?>
                <div class="nav-card loyalty">
                    <div class="emoji">💳</div>
                    <span>Ma Carte Fidélité</span>
                    <div style="font-size: 0.8rem; color: #f1c40f; margin-top: 5px;">
                        <strong><?= $_SESSION['client']->point ?></strong> points accumulés
                    </div>
                </div>
            <?php else: ?>
                <a href="index.php?action=inscription" class="nav-card">
                    <div class="emoji">🆔</div>
                    <span>S'inscrire / Adhérer</span>
                </a>
            <?php endif; ?>
            
            <?php if(isset($_SESSION['client'])): ?>
                <?php $role = $_SESSION['client']->role; ?>
                
                <?php if($role === 'super_admin' || $role === 'admin_comptes'): ?>
                    <a href="index.php?action=admin_membres" class="nav-card">
                        <div class="emoji">👥</div>
                        <span>Gestion Comptes</span>
                    </a>
                <?php endif; ?>

                <?php if($role === 'super_admin' || $role === 'admin_produits' || $role === 'admin_prix' || $role === 'admin_suppression'): ?>
                    <a href="index.php?action=admin_inventaire" class="nav-card">
                        <div class="emoji">📦</div>
                        <span>Gestion Produits</span>
                    </a>
                <?php endif; ?>

                <?php if($role === 'super_admin'): ?>
                    <!-- Carte Spéciale Super Admin pour voir les rôles -->
                    <div class="nav-card" style="border-color: #f1c40f; background: rgba(241, 196, 15, 0.1);">
                        <div class="emoji">👑</div>
                        <span>Rôles Admin</span>
                        <div style="font-size: 0.7rem; color: var(--text-dim); text-align: left; margin-top: 10px;">
                            • ID 2: Articles | ID 3: Prix<br>
                            • ID 4: Comptes | ID 6: Delete
                        </div>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>

    </div>
