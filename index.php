<?php
session_name((require __DIR__ . '/config/config.php')['session_name']);
session_start();
date_default_timezone_set((require __DIR__ . '/config/config.php')['timezone']);

require __DIR__ . '/core/Database.php';
require __DIR__ . '/core/Model.php';
require __DIR__ . '/core/Controller.php';
require __DIR__ . '/core/Router.php';
require __DIR__ . '/core/Auth.php';

require __DIR__ . '/models/User.php';
require __DIR__ . '/models/Patient.php';
require __DIR__ . '/models/Bill.php';

require __DIR__ . '/controllers/AuthController.php';
require __DIR__ . '/controllers/DashboardController.php';
require __DIR__ . '/controllers/PatientsController.php';
require __DIR__ . '/controllers/BillingController.php';
require __DIR__ . '/controllers/ReportsController.php';

$router = new Router();

$router->get('/', [new DashboardController(), 'index']);
$router->get('/login', [new AuthController(), 'showLogin']);
$router->post('/login', [new AuthController(), 'login']);
$router->get('/logout', [new AuthController(), 'logout']);

$router->get('/patients', [new PatientsController(), 'index']);
$router->get('/patients/create', [new PatientsController(), 'create']);
$router->post('/patients', [new PatientsController(), 'store']);

$router->get('/billing/create', [new BillingController(), 'create']);
$router->post('/billing', [new BillingController(), 'store']);
$router->post('/billing/calc', [new BillingController(), 'calculate']);

$router->get('/reports', [new ReportsController(), 'index']);

$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
