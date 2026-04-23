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
        body { font-family: 'Montserrat', sans-serif; background: #f0f2f5; color: #333; display: flex; min-height: 100vh; }

        .main { margin-left: 250px; flex: 1; padding: 35px; overflow-y: auto; }
        .page-title { font-family: 'Playfair Display', serif; font-size: 28px; color: #0f3460; margin-bottom: 30px; }

        .kpi-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 20px; margin-bottom: 35px; }
        .kpi-card {
            background: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.06);
            border-top: 4px solid #0f3460;
        }
        .kpi-card.green { border-top-color: #28a745; }
        .kpi-card.orange { border-top-color: #fd7e14; }
        .kpi-card.red { border-top-color: #dc3545; }
        .kpi-card.gold { border-top-color: #ffc107; }
        .kpi-label { font-size: 11px; font-weight: 600; letter-spacing: 1px; text-transform: uppercase; color: #999; margin-bottom: 10px; }
        .kpi-value { font-size: 32px; font-weight: 700; color: #0f3460; }
        .kpi-card.green .kpi-value { color: #28a745; }
        .kpi-card.orange .kpi-value { color: #fd7e14; }
        .kpi-card.red .kpi-value { color: #dc3545; }
        .kpi-card.gold .kpi-value { color: #856404; }

        .charts-grid { display: grid; grid-template-columns: 2fr 1fr; gap: 25px; margin-bottom: 35px; }
        .chart-card { background: white; border-radius: 12px; padding: 25px; box-shadow: 0 2px 12px rgba(0,0,0,0.06); }
        .chart-title { font-size: 14px; font-weight: 600; color: #0f3460; margin-bottom: 20px; }

        .table-card { background: white; border-radius: 12px; padding: 25px; box-shadow: 0 2px 12px rgba(0,0,0,0.06); }
        .table-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .search-input { padding: 9px 15px; border: 1.5px solid #e0e0e0; border-radius: 8px; font-family: 'Montserrat', sans-serif; font-size: 13px; outline: none; width: 250px; }
        .search-input:focus { border-color: #0f3460; }

        table { width: 100%; border-collapse: collapse; font-size: 13px; }
        th { background: #f8f9fa; color: #666; padding: 12px 15px; text-align: left; font-weight: 600; font-size: 11px; letter-spacing: 0.5px; text-transform: uppercase; border-bottom: 2px solid #e0e0e0; }
        td { padding: 12px 15px; border-bottom: 1px solid #f0f0f0; }
        tr:hover td { background: #fafafa; }

        .statut-form select { padding: 5px 8px; border: 1px solid #ddd; border-radius: 6px; font-size: 12px; cursor: pointer; }
        .statut-form button { padding: 5px 10px; background: #0f3460; color: white; border: none; border-radius: 6px; font-size: 11px; cursor: pointer; margin-left: 5px; }

        @media (max-width: 900px) {
            .main { margin-left: 0; }
            .charts-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <?php include __DIR__ . '/../partials/sidebar.php'; ?>

    <main class="main">
        <div class="page-title">Tableau de bord</div>

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
            <div class="chart-card">
                <div class="chart-title">Reservations par mois</div>
                <canvas id="chartMois" height="100"></canvas>
            </div>
            <div class="chart-card">
                <div class="chart-title">Repartition par hotel</div>
                <canvas id="chartHotel" height="200"></canvas>
            </div>
        </div>

        <div class="table-card">
            <div class="table-header">
                <div class="chart-title" style="margin:0">Toutes les reservations</div>
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
