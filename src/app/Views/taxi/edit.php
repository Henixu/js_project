<?php $taxi_types_json = json_encode($taxi_types); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier la reservation de taxi</title>
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
        input[type="date"], input[type="time"], input[type="text"], input[type="number"], select { padding: 12px 16px; border: 1.5px solid #e0e0e0; border-radius: 8px; font-family: 'Montserrat', sans-serif; font-size: 14px; outline: none; transition: border-color 0.3s; }
        select:focus, input:focus { border-color: #0f3460; }
        .btn { padding: 12px 22px; background: linear-gradient(135deg, #0f3460 0%, #16213e 100%); color: white; border: none; border-radius: 999px; font-family: 'Montserrat', sans-serif; font-size: 13px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; cursor: pointer; transition: transform 0.2s ease, box-shadow 0.2s ease, background 0.2s ease; box-shadow: 0 10px 20px rgba(15, 52, 96, 0.15); }
        .btn:hover { transform: translateY(-1px); box-shadow: 0 14px 24px rgba(15, 52, 96, 0.2); }
        .btn-secondary { background: #f4f6fb; color: #0f3460; box-shadow: inset 0 0 0 1px rgba(15, 52, 96, 0.08); }
        .btn-secondary:hover { background: #e9edf7; }
        .btn-danger { background: #c82333; }
        .btn-danger:hover { background: #a71d2a; }
        .alert { padding: 14px 18px; border-radius: 12px; margin-bottom: 20px; font-size: 14px; }
        .alert-success { background: #e6f7e7; color: #0b4d1d; border: 1px solid #b7deb1; }
        .alert-error { background: #fdf0f1; color: #7a1220; border: 1px solid #f4c2c6; }
        .reservation-info { margin-bottom: 25px; padding: 18px 20px; border: 1px solid #e0e0e0; border-radius: 10px; background: #fafafa; }
        .reservation-info p { margin-bottom: 10px; font-size: 14px; }
        @media (max-width: 600px) { .form-grid { grid-template-columns: 1fr; } .form-group.full { grid-column: 1; } }
    </style>
</head>
<body>
    <div class="topbar">
        <img src="https://slelguoygbfzlpylpxfs.supabase.co/storage/v1/object/public/test-clones/bacaa8ed-efd0-432f-a0ac-5a712ea986ef-seabelhotels-com/assets/images/seabel_hotels_logo-11.svg" alt="Seabel">
        <div class="topbar-right">
            <span>Bonjour, <?= htmlspecialchars((string) ($_SESSION['prenom'] ?? 'Client')) ?></span>
            <a href="<?= htmlspecialchars(app_url('taxi')) ?>">Mes taxis</a>
            <a href="<?= htmlspecialchars(app_url('logout')) ?>">Deconnexion</a>
        </div>
    </div>

    <div class="container">
        <h2>Modifier la reservation de taxi</h2>

        <div class="card">
            <?php if (!empty($success)): ?><div class="alert alert-success"><?= $success ?></div><?php endif; ?>
            <?php if (!empty($error)): ?><div class="alert alert-error"><?= htmlspecialchars((string) $error) ?></div><?php endif; ?>

            <div class="reservation-info">
                <p><strong>Hotel associe :</strong> <?= htmlspecialchars((string) $taxi_reservation['reservation_hotel']) ?></p>
                <p><strong>Date d'arrivee hotel :</strong> <?= htmlspecialchars((string) date('d/m/Y', strtotime((string) $taxi_reservation['date_arrivee']))) ?></p>
                <p><strong>Date de depart hotel :</strong> <?= htmlspecialchars((string) date('d/m/Y', strtotime((string) $taxi_reservation['date_depart']))) ?></p>
            </div>

            <form method="POST" action="<?= htmlspecialchars(app_url('taxi/edit')) ?>">
                <input type="hidden" name="id" value="<?= (int) $taxi_reservation['id'] ?>">
                <div class="form-grid">
                    <div class="form-group full">
                        <label>Adresse de depart</label>
                        <input type="text" name="adresse_depart" value="<?= htmlspecialchars((string) $taxi_reservation['adresse_depart']) ?>" required>
                    </div>
                    <div class="form-group full">
                        <label>Adresse d'arrivee</label>
                        <input type="text" name="adresse_arrivee" value="<?= htmlspecialchars((string) $taxi_reservation['adresse_arrivee']) ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Date de prise en charge</label>
                        <input type="date" name="date_arrivee" value="<?= htmlspecialchars((string) date('Y-m-d', strtotime((string) $taxi_reservation['date_heure']))) ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Heure de prise en charge</label>
                        <input type="time" name="heure_arrivee" value="<?= htmlspecialchars((string) date('H:i', strtotime((string) $taxi_reservation['date_heure']))) ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Type de taxi</label>
                        <select name="type" required>
                            <?php foreach ($taxi_types as $type => $prix): ?>
                                <option value="<?= htmlspecialchars($type) ?>" <?= $type === $taxi_reservation['type'] ? 'selected' : '' ?>><?= htmlspecialchars(ucfirst($type)) ?> - <?= htmlspecialchars((string) $prix) ?> EUR</option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Nombre de passagers</label>
                        <input type="number" name="nb_passagers" min="1" max="6" value="<?= (int) $taxi_reservation['nb_passagers'] ?>">
                    </div>
                </div>
                <div style="display:flex; gap: 15px; flex-wrap:wrap; margin-top: 20px;">
                    <button type="submit" class="btn">Enregistrer</button>
                    <a href="<?= htmlspecialchars(app_url('taxi')) ?>" class="btn btn-secondary">Annuler</a>
                </div>
            </form>

            <form method="POST" action="<?= htmlspecialchars(app_url('taxi/delete')) ?>" style="margin-top: 20px;">
                <input type="hidden" name="id" value="<?= (int) $taxi_reservation['id'] ?>">
                <button type="submit" class="btn btn-danger">Supprimer la reservation</button>
            </form>
        </div>
    </div>
</body>
</html>
