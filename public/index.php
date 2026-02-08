<?php
session_start();

require __DIR__ . '/../app/helpers.php';
require __DIR__ . '/../app/core/Database.php';
require __DIR__ . '/../app/core/Auth.php';
require __DIR__ . '/../app/core/RBAC.php';
require __DIR__ . '/../app/core/Controller.php';

spl_autoload_register(function ($class) {
    $paths = [
        __DIR__ . '/../app/controllers/' . $class . '.php',
        __DIR__ . '/../app/models/' . $class . '.php',
    ];
    foreach ($paths as $path) {
        if (file_exists($path)) {
            require $path;
            return;
        }
    }
});

$route = $_GET['route'] ?? '';

if (!Auth::check() && !in_array($route, ['login', 'authenticate'], true)) {
    $route = 'login';
}

switch ($route) {
    case 'login':
        (new AuthController())->login();
        break;
    case 'authenticate':
        (new AuthController())->authenticate();
        break;
    case 'logout':
        (new AuthController())->logout();
        break;
    case 'users':
        (new UsersController())->index();
        break;
    case 'users/store':
        (new UsersController())->store();
        break;
    case 'users/edit':
        (new UsersController())->edit();
        break;
    case 'users/update':
        (new UsersController())->update();
        break;
    case 'patients':
        (new PatientsController())->index();
        break;
    case 'patients/store':
        (new PatientsController())->store();
        break;
    case 'opd':
        (new OpdController())->index();
        break;
    case 'opd/store':
        (new OpdController())->store();
        break;
    case 'pathology':
        (new PathologyController())->index();
        break;
    case 'pathology/store':
        (new PathologyController())->store();
        break;
    case 'billing/create':
        (new BillingController())->create();
        break;
    case 'billing/store':
        (new BillingController())->store();
        break;
    case 'billing/invoice':
        (new BillingController())->invoice();
        break;
    case 'reports':
        (new ReportsController())->index();
        break;
    default:
        (new DashboardController())->index();
        break;
}
