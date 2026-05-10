<?php
$nav_hotels = $nav_hotels ?? [];
$hotel = $hotel ?? null;
$events = $events ?? [];

$truncate = static function (string $text, int $max): string {
    if (strlen($text) <= $max) {
        return $text;
    }

    return substr($text, 0, $max) . '...';
};
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($hotel ? (string) $hotel['nom'] : 'Hotel introuvable') ?> - Seabel Hotels</title>
    <link rel="stylesheet" href="<?= htmlspecialchars(asset_url('styles.css')) ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&family=Playfair+Display:wght@300;400;700&display=swap" rel="stylesheet">
</head>
<body>
    <?php include __DIR__ . '/../partials/site_header.php'; ?>

    <main class="page-content">
        <?php if ($hotel === null): ?>
            <section class="page-section">
                <div class="container">
                    <h1 class="page-hero-title">Hotel introuvable</h1>
                    <p class="page-hero-subtitle">Ce hotel n'existe pas ou n'est plus disponible.</p>
                    <a class="hotel-card-link" href="hotels.php">Retour aux hotels</a>
                </div>
            </section>
        <?php else: ?>
            <?php
            $imageUrl = trim((string) ($hotel['image_url'] ?? ''));
            $heroStyle = $imageUrl !== '' ? " style=\"background-image: url('" . htmlspecialchars($imageUrl, ENT_QUOTES) . "')\"" : '';
            ?>
            <section class="page-hero page-hero-detail"<?= $heroStyle ?>>
                <div class="page-hero-overlay"></div>
                <div class="page-hero-inner">
                    <p class="page-hero-eyebrow"><?= htmlspecialchars((string) ($hotel['ville'] ?? '')) ?></p>
                    <h1 class="page-hero-title"><?= htmlspecialchars((string) ($hotel['nom'] ?? '')) ?></h1>
                    <div class="page-hero-meta">
                        <span><?= (int) ($hotel['etoiles'] ?? 0) ?> etoiles</span>
                        <span>•</span>
                        <span>A partir de <?= number_format((float) ($hotel['prix_nuit'] ?? 0), 0) ?> EUR / nuit</span>
                    </div>
                </div>
            </section>

            <section class="page-section">
                <div class="container">
                    <div class="hotel-detail-grid">
                        <div class="hotel-detail-main">
                            <h2>Description</h2>
                            <p><?= htmlspecialchars((string) ($hotel['description'] ?? '')) ?></p>
                            <div class="hotel-detail-info">
                                <div>
                                    <strong>Adresse</strong>
                                    <p><?= htmlspecialchars((string) ($hotel['adresse'] ?? '')) ?></p>
                                </div>
                                <div>
                                    <strong>Ville</strong>
                                    <p><?= htmlspecialchars((string) ($hotel['ville'] ?? '')) ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="hotel-detail-card">
                            <h3>Reserver ce sejour</h3>
                            <p>Choisissez vos dates et finalisez votre reservation en quelques clics.</p>
                            <a class="hotel-card-link" href="reservation.php">Reserver maintenant</a>
                        </div>
                    </div>
                </div>
            </section>

            <section class="page-section">
                <div class="container">
                    <div class="section-header">
                        <h2>Evenements a l'hotel</h2>
                        <p>Les animations et soirees a venir pour cet hotel.</p>
                    </div>

                    <?php if ($events === []): ?>
                        <p class="empty-state">Aucun evenement a venir pour le moment.</p>
                    <?php else: ?>
                        <div class="event-grid">
                            <?php foreach ($events as $event): ?>
                                <?php
                                $eventImage = trim((string) ($event['image_url'] ?? ''));
                                $eventStyle = $eventImage !== '' ? " style=\"background-image: url('" . htmlspecialchars($eventImage, ENT_QUOTES) . "')\"" : '';
                                $description = trim((string) ($event['description'] ?? ''));
                                ?>
                                <article class="event-card">
                                    <div class="event-card-media"<?= $eventStyle ?>></div>
                                    <div class="event-card-body">
                                        <h3><?= htmlspecialchars((string) ($event['titre'] ?? '')) ?></h3>
                                        <div class="event-card-meta">
                                            Du <?= htmlspecialchars((string) ($event['date_debut'] ?? '')) ?> au <?= htmlspecialchars((string) ($event['date_fin'] ?? '')) ?>
                                        </div>
                                        <p class="event-card-singer">Avec <?= htmlspecialchars((string) ($event['chanteur'] ?? '')) ?></p>
                                        <?php if ($description !== ''): ?>
                                            <p class="event-card-desc"><?= htmlspecialchars($truncate($description, 150)) ?></p>
                                        <?php endif; ?>
                                    </div>
                                </article>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </section>
        <?php endif; ?>
    </main>

    <?php include __DIR__ . '/../partials/site_footer.php'; ?>
</body>
</html>
