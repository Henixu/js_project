<?php

declare(strict_types=1);

if (!isset($_GET['route'])) {
    $_GET['route'] = 'events-public';
}

require __DIR__ . '/src/index.php';
