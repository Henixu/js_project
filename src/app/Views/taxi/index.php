<?php $taxi_types_json = json_encode($taxi_types); ?>
<?php $confirmed_reservations_json = json_encode($confirmed_reservations ?? []); ?>
<?php $available_reservations_json = json_encode($available_reservations ?? []); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation de Taxi</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600&family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Montserrat', sans-serif; background: #f5f5f5; color: #333; }
        .topbar { background: #0f3460; color: white; padding: 14px 30px; display: flex; justify-content: space-between; align-items: center; }
        .topbar img { height: 35px; filter: brightness(0) invert(1); }
        .topbar-right { display: flex; align-items: center; gap: 20px; font-size: 13px; }
        .topbar-right a { color: rgba(255,255,255,0.8); text-decoration: none; }
        .topbar-right a:hover { color: white; }
        .container { max-width: 900px; margin: 40px auto; padding: 0 20px; }
        h2 { font-family: 'Playfair Display', serif; font-size: 28px; color: #0f3460; margin-bottom: 25px; }
        .card { background: white; border-radius: 12px; padding: 35px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); margin-bottom: 35px; }
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .form-group { display: flex; flex-direction: column; gap: 8px; }
        .form-group.full { grid-column: 1 / -1; }
        label { font-size: 12px; font-weight: 600; letter-spacing: 1px; text-transform: uppercase; color: #666; }
        select, input[type="date"], input[type="datetime-local"], input[type="number"], input[type="text"] {
            padding: 12px 16px;
            border: 1.5px solid #e0e0e0;
            border-radius: 8px;
            font-family: 'Montserrat', sans-serif;
            font-size: 14px;
            outline: none;
            transition: border-color 0.3s;
        }
        select:focus, input:focus { border-color: #0f3460; }
        .prix-preview { background: #f0f4ff; border: 1.5px solid #0f3460; border-radius: 8px; padding: 15px 20px; font-size: 15px; font-weight: 600; color: #0f3460; text-align: center; display: none; }
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
        .badge-attente { background: #fff3cd; color: #856404; }
        .badge-confirmee { background: #d1e7dd; color: #0a3622; }
        .badge-annulee { background: #f8d7da; color: #842029; }
        @media (max-width: 600px) { .form-grid { grid-template-columns: 1fr; } .form-group.full { grid-column: 1; } }
    </style>
</head>
<body>
    <div class="topbar">
        <img src="https://slelguoygbfzlpylpxfs.supabase.co/storage/v1/object/public/test-clones/bacaa8ed-efd0-432f-a0ac-5a712ea986ef-seabelhotels-com/assets/images/seabel_hotels_logo-11.svg" alt="Seabel">
        <div class="topbar-right">
            <span>Bonjour, <?= htmlspecialchars((string) ($_SESSION['prenom'] ?? 'Client')) ?></span>
            <a href="<?= htmlspecialchars(app_url('reservation')) ?>">Hotel</a>
            <a href="<?= htmlspecialchars(app_url('logout')) ?>">Deconnexion</a>
        </div>
    </div>

    <div class="container">
        <h2>Reservation de Taxi</h2>

        <div class="card">
            <?php if (!empty($success)): ?><div class="alert alert-success"><?= $success ?></div><?php endif; ?>
            <?php if (!empty($error)): ?><div class="alert alert-error"><?= htmlspecialchars((string) $error) ?></div><?php endif; ?>
            <?php if (empty($can_book_taxi)): ?><div class="alert alert-error">Vous devez avoir au moins une reservation d'hotel confirmee pour reserver un taxi.</div><?php endif; ?>
            <?php if (!empty($can_book_taxi) && empty($available_reservations)): ?><div class="alert alert-error">Vous avez deja une reservation de taxi pour toutes vos reservations d'hotel confirmees.</div><?php endif; ?>

            <form method="POST" action="<?= htmlspecialchars(app_url('taxi')) ?>" id="taxiForm" <?= (empty($can_book_taxi) || empty($available_reservations)) ? 'style="opacity:0.6;pointer-events:none;"' : '' ?>>
                <div class="form-grid">
                    <div class="form-group full">
                        <label>Reservation hotel associe</label>
                        <select name="reservation_id" id="reservation_id" required>
                            <?php if (empty($available_reservations)): ?>
                                <option value="">Aucune reservation disponible</option>
                            <?php else: ?>
                                <?php foreach ($available_reservations as $reservation): ?>
                                    <option value="<?= (int) $reservation['id'] ?>" <?= ((int) $reservation['id'] === (int) ($last_confirmed_reservation['id'] ?? 0)) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($reservation['hotel'] . ' - ' . date('d/m/Y', strtotime($reservation['date_arrivee']))) ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div class="form-group full">
                        <label>Adresse de depart</label>
                        <select name="adresse_depart" id="adresse_depart" required>
                            <option value="">-- Choisir le point de depart --</option>
                            <option value="Aeroport Tunis-Carthage">Aeroport</option>
                            <option value="Gare Tunis">Gare</option>
                        </select>
                    </div>
                    <div class="form-group full">
                        <label>Adresse d'arrivee</label>
                        <input type="text" name="adresse_arrivee" id="adresse_arrivee" required placeholder="Ex: Aeroport Tunis-Carthage" value="<?= htmlspecialchars((string) ($last_confirmed_reservation['hotel'] ?? '')) ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label>Date de prise en charge</label>
                        <input type="date" name="date_arrivee" id="date_arrivee" required value="<?= htmlspecialchars((string) ($last_confirmed_reservation ? date('Y-m-d', strtotime($last_confirmed_reservation['date_arrivee'])) : '')) ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label>Heure de prise en charge</label>
                        <input type="time" name="heure_arrivee" id="heure_arrivee" required value="<?= htmlspecialchars((string) ($last_confirmed_reservation ? date('H:i', strtotime($last_confirmed_reservation['date_arrivee'])) : '')) ?>">
                    </div>
                    <div class="form-group">
                        <label>Type de taxi</label>
                        <select name="type" id="type" required>
                            <?php foreach ($taxi_types as $type => $prix): ?>
                                <option value="<?= htmlspecialchars($type) ?>"><?= htmlspecialchars(ucfirst($type)) ?> - <?= htmlspecialchars((string) $prix) ?> EUR</option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Nombre de passagers</label>
                        <input type="number" name="nb_passagers" id="nb_passagers" min="1" max="6" value="1">
                    </div>
                    <div class="form-group" style="justify-content: flex-end;">
                        <div class="prix-preview" id="prixPreview">Estimation : --</div>
                    </div>
                    <div class="form-group full" style="align-items: flex-start;">
                        <button type="submit" class="btn" <?= (empty($can_book_taxi) || empty($available_reservations)) ? 'disabled' : '' ?>>Confirmer la reservation</button>
                    </div>
                </div>
            </form>
        </div>

        <h2>Mes reservations de taxi</h2>
        <div class="card">
            <?php if (empty($mes_reservations)): ?>
                <p style="color:#999; text-align:center; padding: 20px;">Aucune reservation de taxi pour le moment.</p>
            <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Depart</th>
                        <th>Arrivee</th>
                        <th>Date / Heure</th>
                        <th>Type</th>
                        <th>Passagers</th>
                        <th>Total</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($mes_reservations as $r): ?>
                    <tr>
                        <td><?= htmlspecialchars((string) $r['adresse_depart']) ?></td>
                        <td><?= htmlspecialchars((string) $r['adresse_arrivee']) ?></td>
                        <td><?= date('d/m/Y H:i', strtotime((string) $r['date_heure'])) ?></td>
                        <td><?= htmlspecialchars(ucfirst((string) $r['type'])) ?></td>
                        <td><?= (int) $r['nb_passagers'] ?></td>
                        <td><?= number_format((float) $r['prix_total'], 2) ?> EUR</td>
                        <td>
                            <a href="<?= htmlspecialchars(app_url('taxi/edit') . '&id=' . (int) $r['id']) ?>" class="btn btn-secondary" style="margin-right: 8px; padding: 8px 14px; font-size: 12px;">Modifier</a>
                            <form method="POST" action="<?= htmlspecialchars(app_url('taxi/delete')) ?>" style="display:inline;">
                                <input type="hidden" name="id" value="<?= (int) $r['id'] ?>">
                                <button type="submit" class="btn btn-danger" style="padding: 8px 14px; font-size: 12px;">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php endif; ?>
        </div>
    </div>

    <script>
        const taxiTypes = <?= $taxi_types_json ?: '{}' ?>;
        const confirmedReservations = <?= $confirmed_reservations_json ?: '[]' ?>;
        const availableReservations = <?= $available_reservations_json ?: '[]' ?>;
        const typeSel = document.getElementById('type');
        const passagersIn = document.getElementById('nb_passagers');
        const preview = document.getElementById('prixPreview');
        const reservationSelect = document.getElementById('reservation_id');
        const arriveeInput = document.getElementById('adresse_arrivee');
        const dateInput = document.getElementById('date_arrivee');

        function updatePreview() {
            const type = typeSel.value;
            const passagers = Number(passagersIn.value) || 1;
            const base = taxiTypes[type] || 35;
            const total = base + Math.max(0, passagers - 1) * 10;
            preview.textContent = `Estimation : ${total.toFixed(2)} EUR`;
            preview.style.display = 'block';
        }

        function updateReservationDetails() {
            if (!reservationSelect) return;
            const selectedId = Number(reservationSelect.value);
            const reservation = availableReservations.find((r) => Number(r.id) === selectedId);
            if (reservation) {
                arriveeInput.value = reservation.hotel || '';
                if (reservation.date_arrivee) {
                    dateInput.value = reservation.date_arrivee;
                }
            }
        }

        [typeSel, passagersIn].forEach((el) => el.addEventListener('change', updatePreview));
        if (reservationSelect) {
            reservationSelect.addEventListener('change', updateReservationDetails);
        }
        updatePreview();
        updateReservationDetails();
    </script>
</body>
</html>
