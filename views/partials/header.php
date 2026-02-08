<?php
$config = require __DIR__ . '/../../config/config.php';
$basePath = rtrim($config['base_path'] ?: dirname($_SERVER['SCRIPT_NAME']), '/');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($config['app_name'], ENT_QUOTES) ?></title>
    <link rel="stylesheet" href="<?= htmlspecialchars($basePath, ENT_QUOTES) ?>/assets/css/styles.css">
</head>
<body data-base-path="<?= htmlspecialchars($basePath, ENT_QUOTES) ?>">
<header class="app-header">
    <div class="logo">🏥 <?= htmlspecialchars($config['app_name'], ENT_QUOTES) ?></div>
    <nav>
        <a href="<?= htmlspecialchars($basePath, ENT_QUOTES) ?>/">Dashboard</a>
        <?php if (Auth::hasPermission('patients.view')): ?>
            <a href="<?= htmlspecialchars($basePath, ENT_QUOTES) ?>/patients">Patients</a>
        <?php endif; ?>
        <?php if (Auth::hasPermission('billing.create')): ?>
            <a href="<?= htmlspecialchars($basePath, ENT_QUOTES) ?>/billing/create">Billing</a>
        <?php endif; ?>
        <?php if (Auth::hasPermission('reports.view')): ?>
            <a href="<?= htmlspecialchars($basePath, ENT_QUOTES) ?>/reports">Reports</a>
        <?php endif; ?>
        <?php if (Auth::check()): ?>
            <a href="<?= htmlspecialchars($basePath, ENT_QUOTES) ?>/logout">Logout</a>
        <?php endif; ?>
    </nav>
</header>
<main class="container">
