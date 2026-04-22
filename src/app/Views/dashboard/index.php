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

        .events-admin-grid { display: grid; grid-template-columns: 1.2fr 1fr; gap: 25px; margin-bottom: 35px; }
        .event-card { background: white; border-radius: 12px; padding: 25px; box-shadow: 0 2px 12px rgba(0,0,0,0.06); }
        .event-form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; }
        .event-form-group { display: flex; flex-direction: column; gap: 7px; }
        .event-form-group.full { grid-column: 1 / -1; }
        .event-label { font-size: 11px; font-weight: 600; letter-spacing: 0.8px; text-transform: uppercase; color: #666; }
        .event-input, .event-textarea {
            padding: 10px 12px;
            border: 1.5px solid #e0e0e0;
            border-radius: 8px;
            font-family: 'Montserrat', sans-serif;
            font-size: 13px;
            outline: none;
        }
        .event-input:focus, .event-textarea:focus { border-color: #0f3460; }
        .event-textarea { min-height: 120px; resize: vertical; }
        .event-btn {
            padding: 12px 16px;
            background: #0f3460;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
            cursor: pointer;
        }
        .event-alert { padding: 10px 12px; border-radius: 8px; margin-bottom: 15px; font-size: 13px; }
        .event-alert-success { background: #e9f9ed; color: #14532d; border: 1px solid #bbf7d0; }
        .event-alert-error { background: #fef2f2; color: #991b1b; border: 1px solid #fecaca; }
        .event-media { width: 54px; height: 54px; border-radius: 8px; object-fit: cover; display: block; }
        .event-media-fallback {
            width: 54px;
            height: 54px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            text-transform: uppercase;
            color: #666;
            background: #f1f5f9;
            border: 1px dashed #cbd5e1;
        }

        @media (max-width: 900px) {
            .sidebar { display: none; }
            .charts-grid { grid-template-columns: 1fr; }
            .events-admin-grid { grid-template-columns: 1fr; }
            .event-form-grid { grid-template-columns: 1fr; }
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
            <a href="<?= htmlspecialchars(app_url('dashboard')) ?>" class="active">Tableau de bord</a>
            <a href="<?= htmlspecialchars(app_url('events')) ?>">Events</a>
            <a href="<?= htmlspecialchars(app_url('reservation')) ?>">Reservations</a>
            <a href="../index.html">Site web</a>
        </nav>
        <div class="sidebar-footer">
            <a href="<?= htmlspecialchars(app_url('logout')) ?>">Deconnexion</a>
        </div>
    </aside>

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

        <div class="events-admin-grid">
            <div class="event-card">
                <div class="chart-title">Ajouter un evenement</div>

                <?php if (!empty($event_success)): ?>
                    <div class="event-alert event-alert-success"><?= htmlspecialchars((string) $event_success) ?></div>
                <?php endif; ?>
                <?php if (!empty($event_error)): ?>
                    <div class="event-alert event-alert-error"><?= htmlspecialchars((string) $event_error) ?></div>
                <?php endif; ?>

                <form method="POST" action="<?= htmlspecialchars(app_url('dashboard')) ?>">
                    <input type="hidden" name="event_action" value="create">
                    <div class="event-form-grid">
                        <div class="event-form-group full">
                            <label class="event-label">Titre de l'evenement</label>
                            <input class="event-input" type="text" name="titre" required value="<?= htmlspecialchars((string) ($event_old['titre'] ?? '')) ?>" placeholder="Soiree musicale seabel">
                        </div>
                        <div class="event-form-group">
                            <label class="event-label">Hotel</label>
                            <input class="event-input" type="text" name="hotel" required value="<?= htmlspecialchars((string) ($event_old['hotel'] ?? '')) ?>" placeholder="Seabel Rym Beach">
                        </div>
                        <div class="event-form-group">
                            <label class="event-label">Chanteur / artiste</label>
                            <input class="event-input" type="text" name="chanteur" required value="<?= htmlspecialchars((string) ($event_old['chanteur'] ?? '')) ?>" placeholder="Nom de l'artiste">
                        </div>
                        <div class="event-form-group">
                            <label class="event-label">Date debut</label>
                            <input class="event-input" type="date" name="date_debut" required value="<?= htmlspecialchars((string) ($event_old['date_debut'] ?? '')) ?>">
                        </div>
                        <div class="event-form-group">
                            <label class="event-label">Date fin</label>
                            <input class="event-input" type="date" name="date_fin" required value="<?= htmlspecialchars((string) ($event_old['date_fin'] ?? '')) ?>">
                        </div>
                        <div class="event-form-group full">
                            <label class="event-label">Description</label>
                            <textarea class="event-textarea" name="description" required placeholder="Details de l'evenement, programme et ambiance..."><?= htmlspecialchars((string) ($event_old['description'] ?? '')) ?></textarea>
                        </div>
                        <div class="event-form-group full">
                            <label class="event-label">Image (URL)</label>
                            <input class="event-input" type="url" name="image_url" value="<?= htmlspecialchars((string) ($event_old['image_url'] ?? '')) ?>" placeholder="https://...">
                        </div>
                        <div class="event-form-group full" style="align-items:flex-start;">
                            <button class="event-btn" type="submit">Publier l'evenement</button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="event-card">
                <div class="chart-title">Evenements publies</div>
                <?php if (empty($events)): ?>
                    <p style="color:#8a8a8a; font-size:13px;">Aucun evenement ajoute pour le moment.</p>
                <?php else: ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Evenement</th>
                                <th>Dates</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($events as $event): ?>
                                <tr>
                                    <td>
                                        <?php if (!empty($event['image_url'])): ?>
                                            <img class="event-media" src="<?= htmlspecialchars((string) $event['image_url']) ?>" alt="Image evenement">
                                        <?php else: ?>
                                            <div class="event-media-fallback">Sans image</div>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <strong><?= htmlspecialchars((string) $event['titre']) ?></strong><br>
                                        <small style="color:#666;"><?= htmlspecialchars((string) $event['hotel']) ?> - <?= htmlspecialchars((string) $event['chanteur']) ?></small><br>
                                        <?php $description = (string) $event['description']; ?>
                                        <small style="color:#9b9b9b;"><?= htmlspecialchars(strlen($description) > 90 ? substr($description, 0, 90) . '...' : $description) ?></small>
                                    </td>
                                    <td>
                                        <?= date('d/m/Y', strtotime((string) $event['date_debut'])) ?><br>
                                        <small style="color:#666;">au <?= date('d/m/Y', strtotime((string) $event['date_fin'])) ?></small>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
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
