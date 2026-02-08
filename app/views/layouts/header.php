<?php
$config = require __DIR__ . '/../../config/config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($config['app']['name']) ?></title>
    <link rel="stylesheet" href="<?= base_url('assets/css/styles.css') ?>">
</head>
<body>
<header class="topbar">
    <div class="logo"><?= e($config['app']['name']) ?></div>
    <?php if (Auth::check()): ?>
        <div class="user-info">
            <span><?= e(Auth::user()['full_name']) ?></span>
            <a href="index.php?route=logout" class="btn-link">Logout</a>
        </div>
    <?php endif; ?>
</header>
<?php if (Auth::check()): ?>
<nav class="sidebar">
    <a href="index.php">Dashboard</a>
    <?php if (RBAC::hasPermission('manage_patients')): ?>
        <a href="index.php?route=patients">Patients</a>
    <?php endif; ?>
    <?php if (RBAC::hasPermission('manage_opd')): ?>
        <a href="index.php?route=opd">OPD Items</a>
    <?php endif; ?>
    <?php if (RBAC::hasPermission('manage_pathology')): ?>
        <a href="index.php?route=pathology">Pathology Items</a>
    <?php endif; ?>
    <?php if (RBAC::hasPermission('manage_billing')): ?>
        <a href="index.php?route=billing/create">Create Bill</a>
    <?php endif; ?>
    <?php if (RBAC::hasPermission('view_reports')): ?>
        <a href="index.php?route=reports">Reports</a>
    <?php endif; ?>
    <?php if (RBAC::hasPermission('manage_users')): ?>
        <a href="index.php?route=users">Users</a>
    <?php endif; ?>
</nav>
<main class="content">
<?php endif; ?>
