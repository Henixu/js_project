<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Locations - Administration</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600&family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Montserrat', sans-serif; background: #f5f5f5; color: #333; display: flex; min-height: 100vh; }
        .main { flex: 1; margin-left: 250px; }
        .page-title { background: white; padding: 25px 35px; border-bottom: 1px solid #e0e0e0; font-family: 'Playfair Display', serif; font-size: 24px; color: #0f3460; }
        .content { padding: 35px; }
        .card { background: white; border-radius: 12px; padding: 35px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); margin-bottom: 35px; }
        .form-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; }
        .form-group { display: flex; flex-direction: column; gap: 8px; }
        label { font-size: 12px; font-weight: 600; letter-spacing: 1px; text-transform: uppercase; color: #666; }
        input, select { padding: 12px 16px; border: 1.5px solid #e0e0e0; border-radius: 8px; font-family: 'Montserrat', sans-serif; font-size: 14px; outline: none; transition: border-color 0.3s; }
        input:focus, select:focus { border-color: #0f3460; }
        .btn { padding: 12px 22px; background: linear-gradient(135deg, #0f3460 0%, #16213e 100%); color: white; border: none; border-radius: 999px; font-family: 'Montserrat', sans-serif; font-size: 13px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; cursor: pointer; transition: transform 0.2s ease, box-shadow 0.2s ease, background 0.2s ease; box-shadow: 0 10px 20px rgba(15, 52, 96, 0.15); }
        .btn:hover { transform: translateY(-1px); box-shadow: 0 14px 24px rgba(15, 52, 96, 0.2); }
        .btn-secondary { background: #f4f6fb; color: #0f3460; box-shadow: inset 0 0 0 1px rgba(15, 52, 96, 0.08); }
        .btn-secondary:hover { background: #e9edf7; }
        .btn-danger { background: #c82333; }
        .btn-danger:hover { background: #a71d2a; }
        .alert { padding: 14px 18px; border-radius: 12px; margin-bottom: 20px; font-size: 14px; }
        .alert-success { background: #e6f7e7; color: #0b4d1d; border: 1px solid #b7deb1; }
        .alert-error { background: #fdf0f1; color: #7a1220; border: 1px solid #f4c2c6; }
        table { width: 100%; border-collapse: collapse; font-size: 13px; }
        th { background: #0f3460; color: white; padding: 12px 15px; text-align: left; font-weight: 500; letter-spacing: 0.5px; }
        td { padding: 12px 15px; border-bottom: 1px solid #f0f0f0; }
        tr:hover td { background: #f9f9f9; }
        .badge { padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 600; text-transform: uppercase; }
        .badge-disponible { background: #d1e7dd; color: #0a3622; }
        .badge-louee { background: #fff3cd; color: #856404; }
        .badge-entretien { background: #f8d7da; color: #842029; }
        .badge-en_attente { background: #fff3cd; color: #856404; }
        .badge-confirmee { background: #d1e7dd; color: #0a3622; }
        .badge-annulee { background: #f8d7da; color: #842029; }
        .badge-terminee { background: #e2e3e5; color: #383d41; }
        .action-buttons { display: flex; gap: 10px; align-items: center; }

        .btn-success { background: #28a745; color: white; }
        .btn-success:hover { background: #218838; }
        .btn-warning { background: #ffc107; color: black; }
        .btn-warning:hover { background: #e0a800; }

        .actions { display: flex; gap: 5px; flex-wrap: wrap; }
        .info-text { font-size: 12px; color: #666; }
        .empty-state { text-align: center; padding: 40px; color: #999; }

        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .main { margin-left: 0; }
        }
    </style>
</head>
<body>
    <?php include __DIR__ . '/../partials/sidebar.php'; ?>

    <main class="main">
        <div class="page-title">Gestion des Locations de Voitures</div>
        <div class="content">
            <div class="card">
                <?php if (empty($car_rentals)): ?>
                    <div class="empty-state">
                        <p>Aucune location de voiture pour le moment.</p>
                    </div>
                <?php else: ?>
                <table>
                    <thead>
                        <tr>
                            <th>Client</th>
                            <th>Voiture</th>
                            <th>Période</th>
                            <th>Prix</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($car_rentals as $rental): ?>
                        <tr>
                            <td>
                                <strong><?= htmlspecialchars($rental['prenom'] . ' ' . $rental['nom']) ?></strong><br>
                                <span class="info-text"><?= htmlspecialchars($rental['email']) ?></span>
                            </td>
                            <td>
                                <?= htmlspecialchars($rental['marque']) ?> <?= htmlspecialchars($rental['modele']) ?><br>
                                <span class="info-text"><?= htmlspecialchars(ucfirst($rental['type'])) ?> • <?= htmlspecialchars(ucfirst($rental['carburant'])) ?></span>
                            </td>
                            <td>
                                <span class="info-text">
                                    Du <?= date('d/m/Y', strtotime($rental['date_debut'])) ?><br>
                                    Au <?= date('d/m/Y', strtotime($rental['date_fin'])) ?>
                                </span>
                            </td>
                            <td><?= number_format((float) $rental['prix_total'], 2) ?> €</td>
                            <td>
                                <span class="badge badge-<?= htmlspecialchars($rental['statut']) ?>">
                                    <?= htmlspecialchars(str_replace('_', ' ', $rental['statut'])) ?>
                                </span>
                            </td>
                            <td>
                                <div class="actions">
                                    <?php if ($rental['statut'] === 'en_attente'): ?>
                                        <form method="POST" style="display:inline;">
                                            <input type="hidden" name="id" value="<?= (int) $rental['id'] ?>">
                                            <input type="hidden" name="statut" value="confirmee">
                                            <button type="submit" class="btn btn-success">Confirmer</button>
                                        </form>
                                    <?php endif; ?>
                                    <?php if ($rental['statut'] !== 'annulee' && $rental['statut'] !== 'terminee'): ?>
                                        <form method="POST" style="display:inline;">
                                            <input type="hidden" name="id" value="<?= (int) $rental['id'] ?>">
                                            <input type="hidden" name="statut" value="annulee">
                                            <button type="submit" class="btn btn-danger">Annuler</button>
                                        </form>
                                    <?php endif; ?>
                                    <?php if ($rental['statut'] === 'confirmee'): ?>
                                        <form method="POST" style="display:inline;">
                                            <input type="hidden" name="id" value="<?= (int) $rental['id'] ?>">
                                            <input type="hidden" name="statut" value="terminee">
                                            <button type="submit" class="btn btn-warning">Terminer</button>
                                        </form>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php endif; ?>
            </div>
        </div>
    </main>
</body>
</html>
