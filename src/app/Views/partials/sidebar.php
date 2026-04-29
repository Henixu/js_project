<aside class="sidebar">
    <div class="sidebar-logo">
        <img src="https://slelguoygbfzlpylpxfs.supabase.co/storage/v1/object/public/test-clones/bacaa8ed-efd0-432f-a0ac-5a712ea986ef-seabelhotels-com/assets/images/seabel_hotels_logo-11.svg" alt="Seabel">
        <p>Administration</p>
    </div>
    <nav>
        <a href="<?= htmlspecialchars(app_url('dashboard')) ?>" <?php echo (basename($_SERVER['PHP_SELF']) === 'index.php' && strpos($_SERVER['REQUEST_URI'], 'dashboard') !== false && strpos($_SERVER['REQUEST_URI'], 'taxis') === false && strpos($_SERVER['REQUEST_URI'], 'rentals') === false) ? 'class="active"' : ''; ?>>Resevation Hotel</a>
        <a href="<?= htmlspecialchars(app_url('dashboard/taxis')) ?>" <?php echo strpos($_SERVER['REQUEST_URI'], 'taxis') !== false ? 'class="active"' : ''; ?>>Taxi</a>
        <a href="<?= htmlspecialchars(app_url('cars')) ?>" <?php echo strpos($_SERVER['REQUEST_URI'], 'cars') !== false && strpos($_SERVER['REQUEST_URI'], 'rent') === false ? 'class="active"' : ''; ?>>Voitures</a>
        <a href="<?= htmlspecialchars(app_url('dashboard/rentals')) ?>" <?php echo strpos($_SERVER['REQUEST_URI'], 'rentals') !== false ? 'class="active"' : ''; ?>>Locations</a>
        <a href="<?= htmlspecialchars(app_url('events')) ?>" <?php echo strpos($_SERVER['REQUEST_URI'], 'events') !== false ? 'class="active"' : ''; ?>>Événements</a>

    </nav>
    <div class="sidebar-footer">
        <a href="<?= htmlspecialchars(app_url('logout')) ?>">Deconnexion</a>
    </div>
</aside>
