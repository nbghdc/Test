<?php
$config = require __DIR__ . '/../../config/config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($config['app_name'], ENT_QUOTES) ?></title>
    <link rel="stylesheet" href="/assets/css/styles.css">
</head>
<body>
<header class="app-header">
    <div class="logo">🏥 <?= htmlspecialchars($config['app_name'], ENT_QUOTES) ?></div>
    <nav>
        <a href="/">Dashboard</a>
        <?php if (Auth::hasPermission('patients.view')): ?>
            <a href="/patients">Patients</a>
        <?php endif; ?>
        <?php if (Auth::hasPermission('billing.create')): ?>
            <a href="/billing/create">Billing</a>
        <?php endif; ?>
        <?php if (Auth::hasPermission('reports.view')): ?>
            <a href="/reports">Reports</a>
        <?php endif; ?>
        <?php if (Auth::check()): ?>
            <a href="/logout">Logout</a>
        <?php endif; ?>
    </nav>
</header>
<main class="container">
