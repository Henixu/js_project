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

if (!function_exists('redirect_to')) {
    function redirect_to(string $route): void
    {
        header('Location: ' . app_url($route));
        exit;
    }
}

if (!function_exists('app_asset_url')) {
    function app_asset_url(string $path): string
    {
        $path = trim($path);
        if ($path === '') {
            return '';
        }

        $normalizedPath = str_replace('\\', '/', $path);

        if (
            preg_match('#^(?:https?:)?//#i', $normalizedPath) === 1 ||
            str_starts_with($normalizedPath, 'data:') ||
            str_starts_with($normalizedPath, 'blob:') ||
            str_starts_with($normalizedPath, '/')
        ) {
            return $normalizedPath;
        }

        $scriptName = $_SERVER['SCRIPT_NAME'] ?? '/src/index.php';
        $basePath = rtrim(str_replace('\\', '/', dirname($scriptName)), '/');

        return ($basePath === '' ? '' : $basePath) . '/' . ltrim($normalizedPath, '/');
    }
}
