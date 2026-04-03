<?php
session_start();
require_once 'php/Modele.php';

// Sécurité : Seuls les admins peuvent voir cette page
// Sécurité : Seuls les admins autorisés peuvent voir cette page
$role_sess = $_SESSION['client']->role ?? 'client';
$can_manage_catalog = ($role_sess === 'super_admin' || $role_sess === 'admin_produits');
$can_edit_prices = ($role_sess === 'super_admin' || $role_sess === 'admin_prix');

if (!isset($_SESSION['client']) || ($role_sess !== 'super_admin' && $role_sess !== 'admin_produits' && $role_sess !== 'admin_prix')) {
    header('Location: index.php');
    exit();
}

$modele = new Modele();
$notif = "";

// Traitement de la suppression
// Traitement de la suppression (Uniquement réservé aux admins produits / super_admin)
if (isset($_GET['delete'])) {
    if (!$can_manage_catalog) {
        $notif = "Erreur : Vous n'avez pas les droits pour supprimer un produit.";
    } else {
        $id_to_delete = $_GET['delete'];
        $res = $modele->supprimerProduit($id_to_delete);
        if ($res === true) {
            $notif = "Produit #$id_to_delete supprimé avec succès.";
        } else {
            $notif = "Erreur lors de la suppression du produit.";
        }
    }
}

if (isset($_GET['msg'])) {
    $notif = $_GET['msg'];
}

$produits = $modele->getAllProduitsWithFamille();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion Produits - Supermarché 2.0</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        @keyframes slideDown {
            from { transform: translateY(-20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        
        .admin-container { max-width: 1200px; width: 98%; }
        
        .data-table-wrapper {
            margin-top: 20px;
            overflow-x: auto;
            border-radius: 20px;
            background: rgba(0, 0, 0, 0.2);
            border: 1px solid var(--glass-border);
            max-height: 500px;
            overflow-y: auto;
        }

        table { width: 100%; border-collapse: collapse; text-align: left; }
        
        th {
            background: rgba(52, 152, 219, 0.2); padding: 20px; color: var(--primary);
            font-weight: 700; text-transform: uppercase; font-size: 0.85rem; letter-spacing: 0.1em;
            position: sticky; top: 0; z-index: 10; backdrop-filter: blur(10px);
        }

        td { padding: 16px 20px; border-bottom: 1px solid var(--glass-border); color: var(--text-main); font-size: 0.95rem; }
        tr:hover { background: rgba(255, 255, 255, 0.05); }

        .action-btns { display: flex; gap: 10px; }
        
        .btn-small {
            display: flex; align-items: center; justify-content: center; width: 38px; height: 38px;
            border-radius: 10px; background: rgba(255, 255, 255, 0.05); border: 1px solid var(--glass-border);
            color: var(--text-main); cursor: pointer; transition: var(--transition); text-decoration: none;
        }

        .btn-small:hover { background: var(--primary); transform: scale(1.1); box-shadow: 0 0 15px var(--primary-glow); }
        .btn-delete:hover { background: #ef5350 !important; box-shadow: 0 0 15px rgba(239, 83, 80, 0.6) !important; }

        .modal-overlay {
            position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(8px); z-index: 1000; display: none; align-items: center; justify-content: center;
            animation: fadeIn 0.3s ease-out;
        }

        .modal-box {
            background: #0f172a; border: 1px solid var(--glass-border); padding: 35px; border-radius: 20px;
            max-width: 450px; width: 90%; box-shadow: 0 20px 50px rgba(0,0,0,0.5); text-align: center;
            animation: scaleUp 0.3s ease-out;
        }

        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        @keyframes scaleUp { from { transform: scale(0.9); opacity: 0; } to { transform: scale(1); opacity: 1; } }

        .modal-title { color: #ef5350; font-size: 1.5rem; font-weight: 700; margin-bottom: 20px; display: flex; align-items: center; justify-content: center; gap: 10px; }
        .modal-text { color: var(--text-main); font-size: 1.1rem; margin-bottom: 15px; }
        
        .product-img-mini {
            width: 50px; height: 50px; object-fit: contain; border-radius: 8px; background: rgba(255,255,255,0.05); padding: 5px;
        }
    </style>
    <script>
        let deleteUrl = "";
        
        function confirmerSuppression(id, nom) {
            document.getElementById('deleteProductName').textContent = "#" + id + " - " + nom;
            deleteUrl = "admin_produits.php?delete=" + id;
            document.getElementById('deleteModal').style.display = 'flex';
        }
        
        function fermerModal() {
            document.getElementById('deleteModal').style.display = 'none';
        }
        
        function executerSuppression() {
            if(deleteUrl !== "") {
                window.location.href = deleteUrl;
            }
        }
    </script>
</head>
<body>

    <div class="container admin-container">
        <div class="titre-1">Administration</div>
        <div class="titre-2">Gestion du catalogue produits</div>

        <?php if($notif): ?>
            <div id="notif-bar" style="padding: 15px 25px; background: rgba(52, 152, 219, 0.2); border: 1px solid var(--primary); border-radius: 12px; color: #fff; margin-bottom: 20px; text-align: center; backdrop-filter: blur(10px); display: flex; justify-content: space-between; align-items: center; animation: slideDown 0.4s ease-out forwards; box-shadow: 0 0 15px var(--primary-glow);">
                <span style="flex-grow: 1; font-weight: 600; font-size: 1.05rem;"><?= htmlspecialchars($notif) ?></span>
                <button onclick="document.getElementById('notif-bar').remove()" style="background: none; border: none; color: #fff; cursor: pointer; font-size: 1.2rem; opacity: 0.7; margin-left: 15px; padding: 5px; transition: 0.3s;" onmouseover="this.style.opacity='1'; this.style.transform='scale(1.2)'" onmouseout="this.style.opacity='0.7'; this.style.transform='scale(1)'">✕</button>
            </div>
        <?php endif; ?>

        <div style="display: flex; gap: 15px; margin-bottom: 25px; justify-content: center;">
            <?php if($role_sess === 'super_admin' || $role_sess === 'admin_comptes'): ?>
                <a href="admin_gestion.php" class="btn-carre" style="background: rgba(255,255,255,0.05); border: 1px solid var(--glass-border); color: var(--text-main); display: flex; align-items: center; justify-content: center; gap: 10px; max-width: 250px;">
                    👥 Gestion Utilisateurs
                </a>
            <?php endif; ?>
            <a href="admin_produits.php" class="btn-carre" style="background: rgba(52, 152, 219, 0.2); border-color: var(--primary); color: white; display: flex; align-items: center; justify-content: center; gap: 10px; max-width: 250px;">
                📦 Gestion Produits
            </a>
            <a href="index.php" class="btn-carre" style="background: rgba(255,255,255,0.05); border: 1px solid var(--glass-border); color: var(--text-main); display: flex; align-items: center; justify-content: center; gap: 10px; max-width: 200px;">
                🏠 Accueil
            </a>
        </div>
        
        <div style="display: flex; justify-content: flex-end; margin-bottom: 10px;">
            <?php if($can_manage_catalog): ?>
                <a href="add_produit.php" class="btn-carre" style="background: #2ecc71; border: none; color: white; max-width: 250px; margin: 0; display: flex; align-items: center; justify-content: center; gap: 10px; box-shadow: 0 0 15px rgba(46, 204, 113, 0.4);">
                    ➕ Nouveau Produit
                </a>
            <?php endif; ?>
        </div>

        <div class="data-table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>ID</th>
                        <th>Nom du produit</th>
                        <th>Rayon</th>
                        <th>Prix</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(count($produits) > 0): ?>
                        <?php foreach ($produits as $p): ?>
                        <tr>
                            <td>
                                <?php $img = !empty($p->Image) ? $p->Image : 'default.png'; ?>
                                <img src="img/<?= htmlspecialchars($img) ?>" class="product-img-mini" alt="<?= htmlspecialchars($p->NomProd) ?>" onerror="this.src='img/default.png'">
                            </td>
                            <td style="font-family: monospace; color: var(--primary); font-weight: 700;">#<?= str_pad($p->IdProduit, 3, '0', STR_PAD_LEFT) ?></td>
                            <td style="font-weight: 600;"><?= htmlspecialchars($p->NomProd) ?></td>
                            <td style="color: var(--text-dim);"><?= htmlspecialchars($p->NomFamille) ?></td>
                            <td>
                                <span style="color: #f1c40f; font-weight: 700; font-size: 1.1rem;"><?= number_format($p->Prix, 2) ?> €</span>
                            </td>
                            <td>
                                <div class="action-btns">
                                    <a href="edit_produit.php?id=<?= $p->IdProduit ?>" class="btn-small" title="Modifier">✏️</a>
                                    <?php if($can_manage_catalog): ?>
                                        <button class="btn-small btn-delete" title="Supprimer" onclick="confirmerSuppression(<?= $p->IdProduit ?>, '<?= addslashes($p->NomProd) ?>')">🗑️</button>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="6" style="text-align: center; color: var(--text-dim); padding: 30px;">Aucun produit dans le catalogue.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <p style="margin-top: 20px; color: var(--text-dim); font-size: 0.9rem;">
            Total produits en catalogue : <strong><?= count($produits) ?></strong>
        </p>
    </div>

    <!-- Custom Modal de Suppression -->
    <div id="deleteModal" class="modal-overlay">
        <div class="modal-box">
            <h3 class="modal-title">🚨 Confirmation Requise</h3>
            <p class="modal-text">Êtes-vous sûr de vouloir supprimer définitivement le produit <br> <strong id="deleteProductName" style="color: var(--primary); font-size: 1.3rem; display: block; margin-top: 10px;"></strong></p>
            <p style="font-size: 0.85rem; color: #ef5350; font-weight: 600; text-transform: uppercase;">Alerte : Cela supprimera le produit des paniers existants.</p>
            <div class="zone-boutons" style="justify-content: center; margin-top: 30px; gap: 15px;">
                <button class="btn-carre" onclick="fermerModal()" style="background: rgba(255,255,255,0.05); border: 1px solid var(--glass-border); color: #fff; padding: 12px 25px; box-shadow: none;">Annuler</button>
                <button class="btn-carre" onclick="executerSuppression()" style="background: #ef5350; border: none; color: #fff; padding: 12px 25px; box-shadow: 0 0 15px rgba(239, 83, 80, 0.4);">Oui, Supprimer</button>
            </div>
        </div>
    </div>

</body>
</html>
