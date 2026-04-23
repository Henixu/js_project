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
    <?php include __DIR__ . '/../partials/sidebar.php'; ?>

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