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

        .main-content { margin-left: 250px; flex: 1; padding: 30px; }
        h1 { color: #0f3460; margin-bottom: 30px; font-size: 32px; }

        .card { background: white; border-radius: 12px; padding: 25px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); margin-bottom: 30px; }

        table { width: 100%; border-collapse: collapse; font-size: 13px; }
        th { background: #0f3460; color: white; padding: 12px 15px; text-align: left; font-weight: 500; }
        td { padding: 12px 15px; border-bottom: 1px solid #f0f0f0; }
        tr:hover td { background: #f9f9f9; }

        .badge {
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            display: inline-block;
        }
        .badge-en_attente { background: #fff3cd; color: #856404; }
        .badge-confirmee { background: #d1e7dd; color: #0a3622; }
        .badge-annulee { background: #f8d7da; color: #842029; }
        .badge-terminee { background: #e2e3e5; color: #383d41; }

        .btn {
            padding: 6px 12px;
            border: none;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .btn-success { background: #28a745; color: white; }
        .btn-success:hover { background: #218838; }
        .btn-warning { background: #ffc107; color: black; }
        .btn-warning:hover { background: #e0a800; }
        .btn-danger { background: #dc3545; color: white; }
        .btn-danger:hover { background: #c82333; }

        .actions { display: flex; gap: 5px; flex-wrap: wrap; }

        .info-text { font-size: 12px; color: #666; }

        .empty-state {
            text-align: center;
            padding: 40px;
            color: #999;
        }

        @media (max-width: 768px) {
            .sidebar { width: 100%; position: relative; height: auto; margin-bottom: 20px; }
            .main-content { margin-left: 0; }
            table { font-size: 12px; }
            td, th { padding: 8px 10px; }
        }
    </style>
</head>
<body>
    <?php include __DIR__ . '/../partials/sidebar.php'; ?>

    <div class="main-content">
        <h1>Gestion des Locations de Voitures</h1>

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
</body>
</html>
