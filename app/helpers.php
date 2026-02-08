<?php
function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

function base_url(string $path = ''): string
{
    $config = require __DIR__ . '/config/config.php';
    $base = rtrim($config['app']['base_url'], '/');
    return $base . '/' . ltrim($path, '/');
}
