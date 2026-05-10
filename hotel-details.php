<?php

declare(strict_types=1);

if (!isset($_GET['route'])) {
    $_GET['route'] = 'hotel-details';
}

require __DIR__ . '/src/index.php';
