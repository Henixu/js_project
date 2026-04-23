<?php $car_types = ['economique' => 'Économique', 'compact' => 'Compact', 'berline' => 'Berline', 'suv' => 'SUV', 'luxe' => 'Luxe']; ?>
<?php $carburants = ['essence' => 'Essence', 'diesel' => 'Diesel', 'hybride' => 'Hybride', 'electrique' => 'Électrique']; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Voitures</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600&family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Montserrat', sans-serif; background: #f5f5f5; color: #333; display: flex; min-height: 100vh; }
        .sidebar { width: 280px; background: #0f3460; color: white; display: flex; flex-direction: column; position: fixed; height: 100vh; left: 0; top: 0; z-index: 100; }
        .sidebar-logo { padding: 0 25px 30px; border-bottom: 1px solid rgba(255,255,255,0.1); }
        .sidebar-logo img { height: 35px; filter: brightness(0) invert(1); }
        .sidebar-logo p { font-size: 11px; color: rgba(255,255,255,0.5); margin-top: 5px; letter-spacing: 1px; text-transform: uppercase; }
        .sidebar nav { padding: 20px 0; flex: 1; }
        .sidebar nav a { display: block; padding: 12px 25px; color: rgba(255,255,255,0.7); text-decoration: none; font-size: 14px; transition: all 0.3s ease; }
        .sidebar nav a:hover, .sidebar nav a.active { background: rgba(255,255,255,0.1); color: white; border-left: 3px solid #e94560; padding-left: 22px; }
        .sidebar-footer { padding: 20px 25px; border-top: 1px solid rgba(255,255,255,0.1); }
        .sidebar-footer a { color: rgba(255,255,255,0.5); font-size: 12px; text-decoration: none; }
        .sidebar-footer a:hover { color: white; }
        .main { flex: 1; margin-left: 280px; }
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
        .action-buttons { display: flex; gap: 10px; align-items: center; }
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .main { margin-left: 0; }
        }
    </style>
</head>
<body>
    <aside class="sidebar">
        <div class="sidebar-logo">
            <img src="https://slelguoygbfzlpylpxfs.supabase.co/storage/v1/object/public/test-clones/bacaa8ed-efd0-432f-a0ac-5a712ea986ef-seabelhotels-com/assets/images/seabel_hotels_logo-11.svg" alt="Seabel">
            <p>Administration</p>
        </div>
        <nav>
            <a href="<?= htmlspecialchars(app_url('dashboard')) ?>">Tableau de bord</a>
            <a href="<?= htmlspecialchars(app_url('dashboard/taxis')) ?>">Taxi</a>
            <a href="<?= htmlspecialchars(app_url('cars')) ?>" class="active">Voitures</a>
            <a href="<?= htmlspecialchars(app_url('reservation')) ?>">Reservations</a>
            <a href="../index.html">Site web</a>
        </nav>
        <div class="sidebar-footer">
            <a href="<?= htmlspecialchars(app_url('logout')) ?>">Deconnexion</a>
        </div>
    </aside>

    <main class="main">
        <div class="page-title">Gestion des Voitures</div>
        <div class="content">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
                <h3 style="margin: 0; color: #0f3460;">Liste des voitures</h3>
                <a href="<?= htmlspecialchars(app_url('cars/add')) ?>" class="btn">Ajouter une voiture</a>
            </div>

        <div class="card">
            <?php if (!empty($success)): ?><div class="alert alert-success"><?= $success ?></div><?php endif; ?>
            <?php if (!empty($error)): ?><div class="alert alert-error"><?= htmlspecialchars((string) $error) ?></div><?php endif; ?>

            <?php if (empty($cars)): ?>
                <p style="color:#999; text-align:center; padding: 20px;">Aucune voiture pour le moment.</p>
            <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Marque</th>
                        <th>Modele</th>
                        <th>Type</th>
                        <th>Portes</th>
                        <th>Carburant</th>
                        <th>Prix/Jour</th>
                        <th>Image</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cars as $car): ?>
                    <tr>
                        <td><?= htmlspecialchars((string) $car['marque']) ?></td>
                        <td><?= htmlspecialchars((string) $car['modele']) ?></td>
                        <td><?= htmlspecialchars(ucfirst((string) $car['type'])) ?></td>
                        <td><?= (int) $car['portes'] ?> portes</td>
                        <td><?= htmlspecialchars(ucfirst((string) $car['carburant'])) ?></td>
                        <td><?= number_format((float) $car['prix_par_jour'], 2) ?> €</td>
                        <td>
                            <?php if (!empty($car['image'])): ?>
                                <img src="<?= htmlspecialchars(app_url('uploads/cars/' . $car['image'])) ?>" alt="Image de la voiture" style="max-width: 80px; max-height: 60px; object-fit: cover;">
                            <?php else: ?>
                                <span style="color:#999;">Aucune image</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <span class="badge badge-<?= htmlspecialchars((string) $car['statut']) ?>">
                                <?= htmlspecialchars(ucfirst((string) $car['statut'])) ?>
                            </span>
                        </td>
                        <td>
                            <a href="<?= htmlspecialchars(app_url('cars/edit') . '&id=' . (int) $car['id']) ?>" class="btn btn-secondary" style="margin-right: 8px; padding: 6px 12px; font-size: 11px;">Modifier</a>
                            <form method="POST" action="<?= htmlspecialchars(app_url('cars/delete')) ?>" style="display:inline;">
                                <input type="hidden" name="id" value="<?= (int) $car['id'] ?>">
                                <button type="submit" class="btn btn-danger" style="padding: 6px 12px; font-size: 11px;">Supprimer</button>
                            </form>
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