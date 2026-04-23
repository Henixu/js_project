<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservations Taxis - Seabel Hotels</title>
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
        .action-buttons { display: flex; gap: 10px; align-items: center; }
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .main { margin-left: 0; }
        }
    </style>
</head>
<body>
    <?php include __DIR__ . '/../partials/sidebar.php'; ?>

    <main class="main">
        <div class="page-title">Reservations de Taxis</div>
        <div class="content">
            <div class="card">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
                    <h3 style="margin: 0; color: #0f3460;">Toutes les reservations de taxi a venir</h3>
                </div>

                <?php if (empty($taxi_reservations)): ?>
                    <p style="color:#999; text-align:center; padding: 20px;">Aucune reservation de taxi a venir.</p>
                <?php else: ?>
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Client</th>
                            <th>Reservation Hotel</th>
                            <th>Depart</th>
                            <th>Arrivee</th>
                            <th>Date / Heure</th>
                            <th>Type</th>
                            <th>Passagers</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($taxi_reservations as $tr): ?>
                        <tr>
                            <td><?= (int) $tr['id'] ?></td>
                            <td>
                                <strong><?= htmlspecialchars((string) ($tr['prenom'] . ' ' . $tr['nom'])) ?></strong><br>
                                <small style="color:#999"><?= htmlspecialchars((string) $tr['email']) ?></small>
                            </td>
                            <td><?= htmlspecialchars((string) ($tr['reservation_hotel'] ?? '')) ?> #<?= (int) ($tr['reservation_id'] ?? 0) ?></td>
                            <td><?= htmlspecialchars((string) $tr['adresse_depart']) ?></td>
                            <td><?= htmlspecialchars((string) $tr['adresse_arrivee']) ?></td>
                            <td><?= date('d/m/Y H:i', strtotime((string) $tr['date_heure'])) ?></td>
                            <td><?= htmlspecialchars(ucfirst((string) $tr['type'])) ?></td>
                            <td><?= (int) $tr['nb_passagers'] ?></td>
                            <td><?= number_format((float) $tr['prix_total'], 2) ?> EUR</td>
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