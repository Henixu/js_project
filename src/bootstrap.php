<?php

declare(strict_types=1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

spl_autoload_register(static function (string $class): void {
    $prefix = 'App\\';
    if (strncmp($class, $prefix, strlen($prefix)) !== 0) {
        return;
    }

    $relativeClass = substr($class, strlen($prefix));
    $file = __DIR__ . '/app/' . str_replace('\\', '/', $relativeClass) . '.php';

    if (is_file($file)) {
        require_once $file;
    }
});

if (!function_exists('app_url')) {
    function app_url(string $route = ''): string
    {
        $scriptName = $_SERVER['SCRIPT_NAME'] ?? '/src/index.php';
        $basePath = rtrim(str_replace('\\', '/', dirname($scriptName)), '/');
        $indexPath = ($basePath === '' ? '' : $basePath) . '/index.php';

        if ($route === '') {
            return $indexPath;
        }

        return $indexPath . '?route=' . urlencode($route);
    }
}

if (!function_exists('asset_url')) {
    /**
     * URL absolue (chemins du site) vers un fichier statique sous le dossier de index.php (ex. uploads/...).
     */
    function asset_url(string $path): string
    {
        $path = ltrim(str_replace('\\', '/', $path), '/');
        $scriptName = $_SERVER['SCRIPT_NAME'] ?? '/src/index.php';
        $basePath = rtrim(str_replace('\\', '/', dirname($scriptName)), '/');

        if ($basePath === '' || $basePath === '.') {
            return '/' . $path;
        }

        return $basePath . '/' . $path;
    }
}

if (!function_exists('car_image_src')) {
    /** Chemin stocké en BDD : uploads/cars/fichier.ext (ou anciennement seulement le nom du fichier). */
    function car_image_src(?string $stored): ?string
    {
        if ($stored === null || $stored === '') {
            return null;
        }

        $stored = str_replace('\\', '/', trim($stored));
        if ($stored !== '' && strpos($stored, '/') === false) {
            $stored = 'uploads/cars/' . $stored;
        }

        return asset_url($stored);
    }
}

if (!function_exists('redirect_to')) {
    function redirect_to(string $route): void
    {
        header('Location: ' . app_url($route));
        exit;
    }
}
