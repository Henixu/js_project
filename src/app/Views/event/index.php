<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Events - Seabel Hotels</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600&family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Montserrat', sans-serif; background: #f0f2f5; color: #333; display: flex; min-height: 100vh; }

        .main { margin-left: 250px; flex: 1; padding: 35px; overflow-y: auto; }
        .page-title { font-family: 'Playfair Display', serif; font-size: 28px; color: #0f3460; margin-bottom: 20px; }

        .card { background: white; border-radius: 12px; padding: 25px; box-shadow: 0 2px 12px rgba(0,0,0,0.06); margin-bottom: 24px; }
        .card-title { font-size: 14px; font-weight: 600; color: #0f3460; margin-bottom: 16px; }

        .alert { padding: 10px 12px; border-radius: 8px; margin-bottom: 15px; font-size: 13px; }
        .alert-success { background: #e9f9ed; color: #14532d; border: 1px solid #bbf7d0; }
        .alert-error { background: #fef2f2; color: #991b1b; border: 1px solid #fecaca; }

        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; }
        .form-group { display: flex; flex-direction: column; gap: 7px; }
        .form-group.full { grid-column: 1 / -1; }
        .field-label { font-size: 11px; font-weight: 600; letter-spacing: 0.8px; text-transform: uppercase; color: #666; }
        .field-input, .field-textarea {
            padding: 10px 12px;
            border: 1.5px solid #e0e0e0;
            border-radius: 8px;
            font-family: 'Montserrat', sans-serif;
            font-size: 13px;
            outline: none;
        }
        .field-input:focus, .field-textarea:focus { border-color: #0f3460; }
        .field-textarea { min-height: 120px; resize: vertical; }

        .actions { display: flex; gap: 10px; align-items: center; }
        .btn {
            padding: 11px 14px;
            border: none;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }
        .btn-primary { background: #0f3460; color: white; }
        .btn-secondary { background: #e5e7eb; color: #111827; }
        .btn-danger { background: #b91c1c; color: white; }

        table { width: 100%; border-collapse: collapse; font-size: 13px; }
        th { background: #f8f9fa; color: #666; padding: 12px 15px; text-align: left; font-weight: 600; font-size: 11px; letter-spacing: 0.5px; text-transform: uppercase; border-bottom: 2px solid #e0e0e0; }
        td { padding: 12px 15px; border-bottom: 1px solid #f0f0f0; vertical-align: top; }
        tr:hover td { background: #fafafa; }

        .mini-actions { display: flex; gap: 8px; }
        .mini-form { display: inline; }
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

        @media (max-width: 950px) {
            .sidebar { display: none; }
            .form-grid { grid-template-columns: 1fr; }
            .form-group.full { grid-column: 1; }
        }
    </style>
</head>
<body>
    <?php include __DIR__ . '/../partials/sidebar.php'; ?>

    <main class="main">
        <div class="page-title">Gestion des events</div>

        <div class="card">
            <div class="card-title"><?= $editing_event ? 'Modifier un event' : 'Ajouter un event' ?></div>

            <?php if (!empty($success)): ?>
                <div class="alert alert-success"><?= htmlspecialchars((string) $success) ?></div>
            <?php endif; ?>
            <?php if (!empty($error)): ?>
                <div class="alert alert-error"><?= htmlspecialchars((string) $error) ?></div>
            <?php endif; ?>

            <?php
                $formSource = $editing_event ?: $old;
                $isEditing = $editing_event !== null;
            ?>

            <form method="POST" action="<?= htmlspecialchars(app_url('events')) ?>" enctype="multipart/form-data">
                <input type="hidden" name="event_action" value="<?= $isEditing ? 'update' : 'create' ?>">
                <input type="hidden" name="MAX_FILE_SIZE" value="3145728">
                <?php if ($isEditing): ?>
                    <input type="hidden" name="id" value="<?= (int) $editing_event['id'] ?>">
                <?php endif; ?>

                <div class="form-grid">
                    <div class="form-group full">
                        <label class="field-label">Titre de l'event</label>
                        <input class="field-input" type="text" name="titre" required value="<?= htmlspecialchars((string) ($formSource['titre'] ?? '')) ?>">
                    </div>
                    <div class="form-group">
                        <label class="field-label">Hotel</label>
                        <?php $selectedHotel = (string) ($formSource['hotel'] ?? ''); ?>
                        <select class="field-input" name="hotel" required>
                            <option value="">-- Choisir un hotel --</option>
                            <?php foreach (($hotels ?? []) as $hotelName): ?>
                                <option value="<?= htmlspecialchars((string) $hotelName) ?>" <?= $selectedHotel === $hotelName ? 'selected' : '' ?>>
                                    <?= htmlspecialchars((string) $hotelName) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="field-label">Chanteur / artiste</label>
                        <input class="field-input" type="text" name="chanteur" required value="<?= htmlspecialchars((string) ($formSource['chanteur'] ?? '')) ?>">
                    </div>
                    <div class="form-group">
                        <label class="field-label">Date debut</label>
                        <input class="field-input" type="date" name="date_debut" required value="<?= htmlspecialchars((string) ($formSource['date_debut'] ?? '')) ?>">
                    </div>
                    <div class="form-group">
                        <label class="field-label">Date fin</label>
                        <input class="field-input" type="date" name="date_fin" required value="<?= htmlspecialchars((string) ($formSource['date_fin'] ?? '')) ?>">
                    </div>
                    <div class="form-group full">
                        <label class="field-label">Description</label>
                        <textarea class="field-textarea" name="description" required><?= htmlspecialchars((string) ($formSource['description'] ?? '')) ?></textarea>
                    </div>
                    <div class="form-group full">
                        <label class="field-label">Image (fichier local, max 3 MB)</label>
                        <input class="field-input" type="file" name="image" accept=".jpg,.jpeg,.png,.gif,.webp,image/jpeg,image/png,image/gif,image/webp">
                        <?php if ($isEditing && !empty($editing_event['image_url'])): ?>
                            <div style="display:flex; align-items:center; gap:10px; margin-top:8px;">
                                <img class="event-media" src="<?= htmlspecialchars(app_asset_url((string) $editing_event['image_url'])) ?>" alt="Image actuelle">
                                <small style="color:#666;">Image actuelle conservee si aucun nouveau fichier n'est choisi.</small>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="form-group full">
                        <div class="actions">
                            <button class="btn btn-primary" type="submit"><?= $isEditing ? 'Mettre a jour' : 'Publier' ?></button>
                            <?php if ($isEditing): ?>
                                <a class="btn btn-secondary" href="<?= htmlspecialchars(app_url('events')) ?>">Annuler</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="card">
            <div class="card-title">Liste des events</div>

            <?php if (empty($events)): ?>
                <p style="color:#8a8a8a; font-size:13px;">Aucun event ajoute pour le moment.</p>
            <?php else: ?>
                <table>
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Event</th>
                            <th>Dates</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($events as $event): ?>
                            <tr>
                                <td>
                                    <?php if (!empty($event['image_url'])): ?>
                                        <img class="event-media" src="<?= htmlspecialchars(app_asset_url((string) $event['image_url'])) ?>" alt="Image event">
                                    <?php else: ?>
                                        <div class="event-media-fallback">Sans image</div>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <strong><?= htmlspecialchars((string) $event['titre']) ?></strong><br>
                                    <small style="color:#666;"><?= htmlspecialchars((string) $event['hotel']) ?> - <?= htmlspecialchars((string) $event['chanteur']) ?></small><br>
                                    <?php $desc = (string) $event['description']; ?>
                                    <small style="color:#9b9b9b;"><?= htmlspecialchars(strlen($desc) > 110 ? substr($desc, 0, 110) . '...' : $desc) ?></small>
                                </td>
                                <td>
                                    <?= date('d/m/Y', strtotime((string) $event['date_debut'])) ?><br>
                                    <small style="color:#666;">au <?= date('d/m/Y', strtotime((string) $event['date_fin'])) ?></small>
                                </td>
                                <td>
                                    <div class="mini-actions">
                                        <a class="btn btn-secondary" href="<?= htmlspecialchars(app_url('events') . '&edit=' . (int) $event['id']) ?>">Modifier</a>
                                        <form class="mini-form" method="POST" action="<?= htmlspecialchars(app_url('events')) ?>" onsubmit="return confirm('Supprimer cet event ?');">
                                            <input type="hidden" name="event_action" value="delete">
                                            <input type="hidden" name="id" value="<?= (int) $event['id'] ?>">
                                            <button class="btn btn-danger" type="submit">Supprimer</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>
