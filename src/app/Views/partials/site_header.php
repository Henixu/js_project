<?php
$nav_hotels = $nav_hotels ?? [];
?>
<header class="header">
    <div class="header-container">
        <div class="header-left">
            <input type="checkbox" id="menu-toggle" class="menu-toggle">
            <label for="menu-toggle" class="menu-overlay"></label>
            <nav class="side-menu">
                <label for="menu-toggle" class="close-menu">&times;</label>
                <ul>
                    <li><a href="index.php">Accueil</a></li>
                    <li><a href="hotels.php">Nos hotels</a></li>
                    <li><a href="events.php">Evenements</a></li>
                    <?php foreach ($nav_hotels as $hotel): ?>
                        <li><a href="hotel-details.php?slug=<?= htmlspecialchars((string) ($hotel['slug'] ?? '')) ?>"><?= htmlspecialchars((string) ($hotel['nom'] ?? '')) ?></a></li>
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
            <a href="reservation.php" class="reserve-button">RESERVER</a>
        </div>
    </div>

    <nav class="mobile-menu">
        <ul>
            <li><a href="index.php">Accueil</a></li>
            <li><a href="hotels.php">Nos hotels</a></li>
            <li><a href="events.php">Evenements</a></li>
            <?php foreach ($nav_hotels as $hotel): ?>
                <li><a href="hotel-details.php?slug=<?= htmlspecialchars((string) ($hotel['slug'] ?? '')) ?>"><?= htmlspecialchars((string) ($hotel['nom'] ?? '')) ?></a></li>
            <?php endforeach; ?>
            <li><a href="#press">Presse & News</a></li>
            <li><a href="#media">Photos & Videos</a></li>
            <li><a href="#protocol">Protocole sanitaire</a></li>
        </ul>
    </nav>
</header>
