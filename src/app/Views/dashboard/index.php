<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Seabel Hotels</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600&family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

        /* Styles spécifiques au dashboard */
        .kpi-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 35px; }
        .kpi-card {
            background: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            border-top: 4px solid #0f3460;
            text-align: center;
        }
        .kpi-card.green { border-top-color: #28a745; }
        .kpi-card.orange { border-top-color: #fd7e14; }
        .kpi-card.red { border-top-color: #dc3545; }
        .kpi-card.gold { border-top-color: #ffc107; }
        .kpi-label { font-size: 12px; font-weight: 600; letter-spacing: 1px; text-transform: uppercase; color: #999; margin-bottom: 10px; }
        .kpi-value { font-size: 28px; font-weight: 700; color: #0f3460; }
        .kpi-card.green .kpi-value { color: #28a745; }
        .kpi-card.orange .kpi-value { color: #fd7e14; }
        .kpi-card.red .kpi-value { color: #dc3545; }
        .kpi-card.gold .kpi-value { color: #856404; }

        .charts-grid { display: grid; grid-template-columns: 2fr 1fr; gap: 25px; margin-bottom: 35px; }
        .chart-card { background: white; border-radius: 12px; padding: 25px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); }
        .chart-title { font-size: 16px; font-weight: 600; color: #0f3460; margin-bottom: 20px; }

        .search-input { padding: 9px 15px; border: 1.5px solid #e0e0e0; border-radius: 8px; font-family: 'Montserrat', sans-serif; font-size: 13px; outline: none; width: 250px; }
        .search-input:focus { border-color: #0f3460; }

        .statut-form select { padding: 5px 8px; border: 1px solid #ddd; border-radius: 6px; font-size: 12px; cursor: pointer; }
        .statut-form button { padding: 5px 10px; background: #0f3460; color: white; border: none; border-radius: 6px; font-size: 11px; cursor: pointer; margin-left: 5px; }

        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .main { margin-left: 0; }
            .charts-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <?php include __DIR__ . '/../partials/sidebar.php'; ?>

    <main class="main">
        <div class="page-title">Reservation</div>
        <div class="content">
            <div class="kpi-grid">
                <div class="kpi-card">
                    <div class="kpi-label">Total reservations</div>
                    <div class="kpi-value"><?= (int) ($stats['total'] ?? 0) ?></div>
                </div>
                <div class="kpi-card green">
                    <div class="kpi-label">Confirmees</div>
                    <div class="kpi-value"><?= (int) ($stats['confirmees'] ?? 0) ?></div>
                </div>
                <div class="kpi-card orange">
                    <div class="kpi-label">En attente</div>
                    <div class="kpi-value"><?= (int) ($stats['en_attente'] ?? 0) ?></div>
                </div>
                <div class="kpi-card red">
                    <div class="kpi-label">Annulees</div>
                    <div class="kpi-value"><?= (int) ($stats['annulees'] ?? 0) ?></div>
                </div>
                <div class="kpi-card gold">
                    <div class="kpi-label">Revenus confirmes</div>
                    <div class="kpi-value"><?= number_format((float) ($stats['revenus'] ?? 0), 0, ',', ' ') ?> EUR</div>
                </div>
            </div>

            <div class="charts-grid">
                <div class="card">
                    <div class="chart-title">Reservations par mois</div>
                    <canvas id="chartMois" height="100"></canvas>
                </div>
                <div class="card">
                    <div class="chart-title">Repartition par hotel</div>
                    <canvas id="chartHotel" height="200"></canvas>
                </div>
            </div>

            <div class="card">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
                    <h3 style="margin: 0; color: #0f3460;">Toutes les reservations</h3>
                    <input type="text" class="search-input" id="searchInput" placeholder="Rechercher client, hotel...">
                </div>
                <table id="reservTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Client</th>
                            <th>Hotel</th>
                            <th>Chambre</th>
                            <th>Arrivee</th>
                            <th>Depart</th>
                            <th>Pers.</th>
                            <th>Total</th>
                            <th>Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($reservations as $r): ?>
                        <tr>
                            <td><?= (int) $r['id'] ?></td>
                            <td>
                                <strong><?= htmlspecialchars((string) ($r['prenom'] . ' ' . $r['nom'])) ?></strong><br>
                                <small style="color:#999"><?= htmlspecialchars((string) $r['email']) ?></small>
                            </td>
                            <td><?= htmlspecialchars((string) $r['hotel']) ?></td>
                            <td><?= htmlspecialchars((string) $r['chambre']) ?></td>
                            <td><?= date('d/m/Y', strtotime((string) $r['date_arrivee'])) ?></td>
                            <td><?= date('d/m/Y', strtotime((string) $r['date_depart'])) ?></td>
                            <td><?= (int) $r['nb_personnes'] ?></td>
                            <td><?= number_format((float) $r['prix_total'], 0) ?> EUR</td>
                            <td>
                                <form method="POST" class="statut-form" style="display:flex;align-items:center;" action="<?= htmlspecialchars(app_url('dashboard')) ?>">
                                    <input type="hidden" name="id" value="<?= (int) $r['id'] ?>">
                                    <select name="statut">
                                        <option value="en_attente" <?= $r['statut'] === 'en_attente' ? 'selected' : '' ?>>En attente</option>
                                        <option value="confirmee" <?= $r['statut'] === 'confirmee' ? 'selected' : '' ?>>Confirmee</option>
                                        <option value="annulee" <?= $r['statut'] === 'annulee' ? 'selected' : '' ?>>Annulee</option>
                                    </select>
                                    <button type="submit">OK</button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <script>
        new Chart(document.getElementById('chartMois'), {
            type: 'bar',
            data: {
                labels: <?= $mois_labels ?: '[]' ?>,
                datasets: [{
                    label: 'Reservations',
                    data: <?= $mois_data ?: '[]' ?>,
                    backgroundColor: '#0f3460',
                    borderRadius: 6
                }]
            },
            options: { plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } } }
        });

        new Chart(document.getElementById('chartHotel'), {
            type: 'doughnut',
            data: {
                labels: <?= $hotel_labels ?: '[]' ?>,
                datasets: [{
                    data: <?= $hotel_data ?: '[]' ?>,
                    backgroundColor: ['#0f3460', '#e94560', '#16213e']
                }]
            },
            options: { plugins: { legend: { position: 'bottom' } } }
        });

        document.getElementById('searchInput').addEventListener('input', function () {
            const q = this.value.toLowerCase();
            document.querySelectorAll('#reservTable tbody tr').forEach((row) => {
                row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
            });
        });
    </script>
</body>
</html>
