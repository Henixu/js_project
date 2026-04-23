<style>
    .sidebar {
        width: 250px;
        background: #0f3460;
        color: white;
        padding: 20px;
        position: fixed;
        height: 100vh;
        overflow-y: auto;
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
        font-size: 14px;
        transition: all 0.3s ease;
    }
    .sidebar nav a:hover, .sidebar nav a.active { background: rgba(255,255,255,0.1); color: white; border-left: 3px solid #e94560; padding-left: 22px; }
    .sidebar-footer { padding: 20px 25px; border-top: 1px solid rgba(255,255,255,0.1); }
    .sidebar-footer a { color: rgba(255,255,255,0.5); font-size: 12px; text-decoration: none; }
    .sidebar-footer a:hover { color: white; }
</style>

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
