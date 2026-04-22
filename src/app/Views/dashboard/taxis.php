<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservations Taxis - Seabel Hotels</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600&family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Montserrat', sans-serif; background: #f0f2f5; color: #333; display: flex; min-height: 100vh; }

        .sidebar {
            width: 240px;
            background: #0f3460;
            color: white;
            padding: 30px 0;
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
        }
        .sidebar-logo { padding: 0 25px 30px; border-bottom: 1px solid rgba(255,255,255,0.1); }
        .sidebar-logo img { height: 35px; filter: brightness(0) invert(1); }
        .sidebar-logo p { font-size: 11px; color: rgba(255,255,255,0.5); margin-top: 5px; letter-spacing: 1px; text-transform: uppercase; }
        .sidebar nav { padding: 20px 0; flex: 1; }
        .sidebar nav a {
            display: block;
            padding: 12px 25px;
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
            transition: all 0.2s;
        }
        .sidebar nav a:hover, .sidebar nav a.active { background: rgba(255,255,255,0.1); color: white; border-left: 3px solid #e94560; padding-left: 22px; }
        .sidebar-footer { padding: 20px 25px; border-top: 1px solid rgba(255,255,255,0.1); }
        .sidebar-footer a { color: rgba(255,255,255,0.5); font-size: 12px; text-decoration: none; }
        .sidebar-footer a:hover { color: white; }

        .main { flex: 1; padding: 35px; overflow-y: auto; }
        .page-title { font-family: 'Playfair Display', serif; font-size: 28px; color: #0f3460; margin-bottom: 30px; }

        .table-card {
            background: white;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.06);
            margin-bottom: 30px;
        }

        .table-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        table { width: 100%; border-collapse: collapse; font-size: 13px; }
        th { background: #f8f9fa; color: #666; padding: 12px 15px; text-align: left; font-weight: 600; font-size: 11px; letter-spacing: 0.5px; text-transform: uppercase; border-bottom: 2px solid #e0e0e0; }
        td { padding: 12px 15px; border-bottom: 1px solid #f0f0f0; }
        tr:hover td { background: #fafafa; }

        @media (max-width: 900px) {
            .sidebar { display: none; }
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
            <a href="<?= htmlspecialchars(app_url('dashboard/taxis')) ?>" class="active">Taxi</a>
            <a href="<?= htmlspecialchars(app_url('cars')) ?>">Voitures</a>
            <a href="<?= htmlspecialchars(app_url('reservation')) ?>">Reservations</a>
            <a href="../index.html">Site web</a>
        </nav>
        <div class="sidebar-footer">
            <a href="<?= htmlspecialchars(app_url('logout')) ?>">Deconnexion</a>
        </div>
    </aside>

    <main class="main">
        <div class="page-title">Reservations de Taxis</div>

        <div class="table-card">
            <div class="table-header">
                <div style="font-family: 'Playfair Display', serif; font-size: 20px; color: #0f3460; margin: 0;">Toutes les reservations de taxi a venir</div>
            </div>
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
            <?php if (empty($taxi_reservations)): ?>
                <p style="color:#999; text-align:center; padding: 40px;">Aucune reservation de taxi a venir.</p>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>