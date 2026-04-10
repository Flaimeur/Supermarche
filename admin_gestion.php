<?php
session_start();
require_once 'php/Modele.php';

// Sécurité : Seuls les admins peuvent voir cette page
if (!isset($_SESSION['client']) || $_SESSION['client']->EstAdmin != 1) {
    header('Location: index.php');
    exit();
}

$modele = new Modele();
$notif = "";

// Traitement de la suppression
if (isset($_GET['delete'])) {
    $id_to_delete = $_GET['delete'];
    if ($id_to_delete == $_SESSION['client']->IdClient) {
        $notif = "Erreur : Vous ne pouvez pas supprimer votre propre compte admin.";
    } else {
        $res = $modele->supprimerClient($id_to_delete);
        if ($res === true) {
            $notif = "Utilisateur #$id_to_delete supprimé avec succès (avec tout son historique).";
        } else {
            $notif = "Erreur lors de la suppression de l'utilisateur.";
        }

    }
}

if (isset($_GET['msg'])) {
    $notif = $_GET['msg'];
}

$clients = $modele->getAllClients();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion Utilisateurs - Supermarché 2.0</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        @keyframes slideDown {
            from { transform: translateY(-20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        
        .admin-container {
            max-width: 1200px;
            width: 98%;
        }
        
        .data-table-wrapper {
            margin-top: 30px;
            overflow-x: auto;
            border-radius: 20px;
            background: rgba(0, 0, 0, 0.2);
            border: 1px solid var(--glass-border);
            max-height: 500px;
            overflow-y: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        th {
            background: rgba(52, 152, 219, 0.2);
            padding: 20px;
            color: var(--primary);
            font-weight: 700;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.1em;
            position: sticky;
            top: 0;
            z-index: 10;
            backdrop-filter: blur(10px);
        }

        td {
            padding: 16px 20px;
            border-bottom: 1px solid var(--glass-border);
            color: var(--text-main);
            font-size: 0.95rem;
        }

        tr:hover {
            background: rgba(255, 255, 255, 0.05);
        }

        .badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
        }

        .badge-admin {
            background: rgba(52, 152, 219, 0.2);
            color: #3498db;
            border: 1px solid rgba(52, 152, 219, 0.4);
        }

        .badge-user {
            background: rgba(148, 163, 184, 0.1);
            color: var(--text-dim);
            border: 1px solid rgba(148, 163, 184, 0.2);
        }

        .action-btns {
            display: flex;
            gap: 10px;
        }

        .btn-small {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--glass-border);
            color: var(--text-main);
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
        }

        .btn-small:hover {
            background: var(--primary);
            transform: scale(1.1);
            box-shadow: 0 0 15px var(--primary-glow);
        }

        .btn-delete:hover {
            background: #ef5350 !important;
            box-shadow: 0 0 15px rgba(239, 83, 80, 0.6) !important;
        }

        .modal-overlay {
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(8px);
            z-index: 1000;
            display: none;
            align-items: center;
            justify-content: center;
            animation: fadeIn 0.3s ease-out;
        }

        .modal-box {
            background: #0f172a;
            border: 1px solid var(--glass-border);
            padding: 35px;
            border-radius: 20px;
            max-width: 450px;
            width: 90%;
            box-shadow: 0 20px 50px rgba(0,0,0,0.5);
            text-align: center;
            animation: scaleUp 0.3s ease-out;
        }

        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        @keyframes scaleUp { from { transform: scale(0.9); opacity: 0; } to { transform: scale(1); opacity: 1; } }

        .modal-title {
            color: #ef5350;
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 20px;
            margin-top: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .modal-text {
            color: var(--text-main);
            font-size: 1.1rem;
            margin-bottom: 15px;
        }
    </style>
    <script>
        let deleteUrl = "";
        
        function confirmerSuppression(id, nom) {
            document.getElementById('deleteUserName').textContent = "#" + id + " - " + nom;
            deleteUrl = "admin_gestion.php?delete=" + id;
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
        <div class="titre-2">Gestion des comptes clients</div>

        <?php if($notif): ?>
            <div id="notif-bar" style="padding: 15px 25px; background: rgba(52, 152, 219, 0.2); border: 1px solid var(--primary); border-radius: 12px; color: #fff; margin-bottom: 20px; text-align: center; backdrop-filter: blur(10px); display: flex; justify-content: space-between; align-items: center; animation: slideDown 0.4s ease-out forwards; box-shadow: 0 0 15px var(--primary-glow);">
                <span style="flex-grow: 1; font-weight: 600; font-size: 1.05rem;"><?= htmlspecialchars($notif) ?></span>
                <button onclick="document.getElementById('notif-bar').remove()" style="background: none; border: none; color: #fff; cursor: pointer; font-size: 1.2rem; opacity: 0.7; margin-left: 15px; padding: 5px; transition: 0.3s;" onmouseover="this.style.opacity='1'; this.style.transform='scale(1.2)'" onmouseout="this.style.opacity='0.7'; this.style.transform='scale(1)'">✕</button>
            </div>
        <?php endif; ?>

        <div style="display: flex; gap: 15px; margin-bottom: 25px; justify-content: center;">
            <a href="admin_gestion.php" class="btn-carre" style="background: rgba(52, 152, 219, 0.2); border-color: var(--primary); color: white; display: flex; align-items: center; justify-content: center; gap: 10px; max-width: 250px;">
                👥 Gestion Utilisateurs
            </a>
            <a href="admin_produits.php" class="btn-carre" style="background: rgba(255,255,255,0.05); border: 1px solid var(--glass-border); color: var(--text-main); display: flex; align-items: center; justify-content: center; gap: 10px; max-width: 250px;">
                📦 Gestion Produits
            </a>
            <a href="index.php" class="btn-carre" style="background: rgba(255,255,255,0.05); border: 1px solid var(--glass-border); color: var(--text-main); display: flex; align-items: center; justify-content: center; gap: 10px; max-width: 200px;">
                🏠 Accueil
            </a>
        </div>

        <div class="data-table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom & Prénom</th>
                        <th>Ville</th>
                        <th>Points</th>
                        <th>Rôle</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($clients as $c): ?>
                    <tr>
                        <td style="font-family: monospace; color: var(--primary); font-weight: 700;">#<?= str_pad($c->IdClient, 3, '0', STR_PAD_LEFT) ?></td>
                        <td>
                            <div style="font-weight: 600;"><?= htmlspecialchars($c->Nom) ?> <?= htmlspecialchars($c->Prenom) ?></div>
                            <div style="font-size: 0.8rem; color: var(--text-dim);"><?= htmlspecialchars($c->Adresse) ?></div>
                        </td>
                        <td><?= htmlspecialchars($c->Ville) ?></td>
                        <td>
                            <span style="color: #f1c40f; font-weight: 700;"><?= $c->point ?></span> pts
                        </td>
                        <td>
                            <?php if ($c->EstAdmin == 1): ?>
                                <span class="badge badge-admin">Admin</span>
                            <?php else: ?>
                                <span class="badge badge-user">Client</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="action-btns">
                                <a href="edit_client.php?id=<?= $c->IdClient ?>" class="btn-small" title="Modifier">✏️</a>
                                <button class="btn-small btn-delete" title="Supprimer" onclick="confirmerSuppression(<?= $c->IdClient ?>, '<?= addslashes($c->Nom . ' ' . $c->Prenom) ?>')">🗑️</button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <p style="margin-top: 20px; color: var(--text-dim); font-size: 0.9rem;">
            Total adhérents enregistrés : <strong><?= count($clients) ?></strong>
        </p>
    </div>

    <!-- Custom Modal de Suppression -->
    <div id="deleteModal" class="modal-overlay">
        <div class="modal-box">
            <h3 class="modal-title">🚨 Confirmation Requise</h3>
            <p class="modal-text">Êtes-vous sûr de vouloir supprimer définitivement l'utilisateur <br> <strong id="deleteUserName" style="color: var(--primary); font-size: 1.3rem; display: block; margin-top: 10px;"></strong></p>
            <p style="font-size: 0.85rem; color: #ef5350; font-weight: 600; text-transform: uppercase;">Action irréversible</p>
            <div class="zone-boutons" style="justify-content: center; margin-top: 30px; gap: 15px;">
                <button class="btn-carre" onclick="fermerModal()" style="background: rgba(255,255,255,0.05); border: 1px solid var(--glass-border); color: #fff; padding: 12px 25px; box-shadow: none;">Annuler</button>
                <button class="btn-carre" onclick="executerSuppression()" style="background: #ef5350; border: none; color: #fff; padding: 12px 25px; box-shadow: 0 0 15px rgba(239, 83, 80, 0.4);">Oui, Supprimer</button>
            </div>
        </div>
    </div>

</body>
</html>
