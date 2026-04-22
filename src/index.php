<?php

declare(strict_types=1);

require_once __DIR__ . '/bootstrap.php';

use App\Controllers\AuthController;
use App\Controllers\DashboardController;
use App\Controllers\ReservationController;
use App\Core\Router;

$router = new Router();

$authController = new AuthController();
$reservationController = new ReservationController();
$dashboardController = new DashboardController();

$router->add('GET', '', static function (): void {
    if (isset($_SESSION['user_id'])) {
        redirect_to(($_SESSION['role'] ?? 'client') === 'admin' ? 'dashboard' : 'reservation');
    }

    redirect_to('login');
});

$router->add('GET', 'login', static function () use ($authController): void {
    $authController->login();
});
$router->add('POST', 'login', static function () use ($authController): void {
    $authController->login();
});

$router->add('GET', 'register', static function () use ($authController): void {
    $authController->register();
});
$router->add('POST', 'register', static function () use ($authController): void {
    $authController->register();
});

$router->add('GET', 'logout', static function () use ($authController): void {
    $authController->logout();
});

$router->add('GET', 'reservation', static function () use ($reservationController): void {
    $reservationController->index();
});
$router->add('POST', 'reservation', static function () use ($reservationController): void {
    $reservationController->index();
});

$router->add('GET', 'dashboard', static function () use ($dashboardController): void {
    $dashboardController->index();
});
$router->add('POST', 'dashboard', static function () use ($dashboardController): void {
    $dashboardController->index();
});

$route = trim((string) ($_GET['route'] ?? ''), '/');
$method = strtoupper((string) ($_SERVER['REQUEST_METHOD'] ?? 'GET'));

$router->dispatch($method, $route);
