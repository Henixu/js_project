<?php
$nav_hotels = $nav_hotels ?? [];
$home_url = app_url('home');
$hotels_url = app_url('hotels');
$events_url = app_url('events-public');
$hotel_details_base = app_url('hotel-details');
$reservation_url = app_url('reservation');
?>
<header class="header">
    <div class="header-container">
        <div class="header-left">
            <input type="checkbox" id="menu-toggle" class="menu-toggle">
            <label for="menu-toggle" class="menu-overlay"></label>
            <nav class="side-menu">
                <label for="menu-toggle" class="close-menu">&times;</label>
                <ul>
                    <li><a href="<?= htmlspecialchars($home_url) ?>">Accueil</a></li>
                    <li><a href="<?= htmlspecialchars($hotels_url) ?>">Nos hotels</a></li>
                    <li><a href="<?= htmlspecialchars($events_url) ?>">Evenements</a></li>
                    <?php foreach ($nav_hotels as $hotel): ?>
                        <li><a href="<?= htmlspecialchars($hotel_details_base . '&slug=' . rawurlencode((string) ($hotel['slug'] ?? ''))) ?>"><?= htmlspecialchars((string) ($hotel['nom'] ?? '')) ?></a></li>
                    <?php endforeach; ?>
                    <li><a href="#press">Presse & News</a></li>
                    <li><a href="#contact">Contact</a></li>
                    <li><a href="#protocol">Protocole sanitaire</a></li>
                </ul>
            </nav>
            <label for="menu-toggle" class="menu-button">
                <span class="hamburger"></span>
                <span class="menu-text">MENU</span>
            </label>
        </div>

        <div class="header-center">
            <img src="https://www.01net.com/app/uploads/2024/05/Design-sans-titre162.jpg" alt="seabel Hotels" class="logo">
        </div>

        <div class="header-right">
            <a href="<?= htmlspecialchars($reservation_url) ?>" class="reserve-button">RESERVER</a>
        </div>
    </div>

    <nav class="mobile-menu">
        <ul>
            <li><a href="<?= htmlspecialchars($home_url) ?>">Accueil</a></li>
            <li><a href="<?= htmlspecialchars($hotels_url) ?>">Nos hotels</a></li>
            <li><a href="<?= htmlspecialchars($events_url) ?>">Evenements</a></li>
            <?php foreach ($nav_hotels as $hotel): ?>
                <li><a href="<?= htmlspecialchars($hotel_details_base . '&slug=' . rawurlencode((string) ($hotel['slug'] ?? ''))) ?>"><?= htmlspecialchars((string) ($hotel['nom'] ?? '')) ?></a></li>
            <?php endforeach; ?>
            <li><a href="#press">Presse & News</a></li>
            <li><a href="#media">Photos & Videos</a></li>
            <li><a href="#protocol">Protocole sanitaire</a></li>
        </ul>
    </nav>
</header>
