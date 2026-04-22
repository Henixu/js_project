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
    .sidebar-logo { display: flex; align-items: center; gap: 10px; margin-bottom: 30px; }
    .sidebar-logo img { height: 40px; filter: brightness(0) invert(1); }
    .sidebar-logo p { font-size: 16px; font-weight: 600; }
    .sidebar nav { display: flex; flex-direction: column; gap: 10px; }
    .sidebar nav a {
        padding: 12px 15px;
        border-radius: 8px;
        text-decoration: none;
        color: rgba(255,255,255,0.8);
        transition: background 0.3s;
        font-size: 14px;
    }
    .sidebar nav a:hover { background: rgba(255,255,255,0.1); }
    .sidebar nav a.active { background: #16213e; color: white; font-weight: 600; }
    .sidebar-footer { position: absolute; bottom: 20px; left: 20px; right: 20px; }
    .sidebar-footer a {
        display: block;
        padding: 12px 15px;
        border-radius: 8px;
        text-decoration: none;
        color: rgba(255,255,255,0.8);
        text-align: center;
        background: rgba(255,255,255,0.1);
        transition: background 0.3s;
    }
    .sidebar-footer a:hover { background: rgba(255,255,255,0.2); }
</style>

<aside class="sidebar">
    <div class="sidebar-logo">
        <img src="https://slelguoygbfzlpylpxfs.supabase.co/storage/v1/object/public/test-clones/bacaa8ed-efd0-432f-a0ac-5a712ea986ef-seabelhotels-com/assets/images/seabel_hotels_logo-11.svg" alt="Seabel">
        <p>Administration</p>
    </div>
    <nav>
        <a href="<?= htmlspecialchars(app_url('dashboard')) ?>" <?php echo (basename($_SERVER['PHP_SELF']) === 'index.php' && strpos($_SERVER['REQUEST_URI'], 'dashboard') !== false && strpos($_SERVER['REQUEST_URI'], 'taxis') === false && strpos($_SERVER['REQUEST_URI'], 'rentals') === false) ? 'class="active"' : ''; ?>>Tableau de bord</a>
        <a href="<?= htmlspecialchars(app_url('dashboard/taxis')) ?>" <?php echo strpos($_SERVER['REQUEST_URI'], 'taxis') !== false ? 'class="active"' : ''; ?>>Taxi</a>
        <a href="<?= htmlspecialchars(app_url('cars')) ?>" <?php echo strpos($_SERVER['REQUEST_URI'], 'cars') !== false && strpos($_SERVER['REQUEST_URI'], 'rent') === false ? 'class="active"' : ''; ?>>Voitures</a>
        <a href="<?= htmlspecialchars(app_url('dashboard/rentals')) ?>" <?php echo strpos($_SERVER['REQUEST_URI'], 'rentals') !== false ? 'class="active"' : ''; ?>>Locations</a>
    </nav>
    <div class="sidebar-footer">
        <a href="<?= htmlspecialchars(app_url('logout')) ?>">Deconnexion</a>
    </div>
</aside>
