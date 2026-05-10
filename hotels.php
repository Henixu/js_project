<?php

declare(strict_types=1);

if (!isset($_GET['route'])) {
    $_GET['route'] = 'hotels';
}

require __DIR__ . '/src/index.php';
