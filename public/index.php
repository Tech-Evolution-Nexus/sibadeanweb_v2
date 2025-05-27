<?php

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__ . '/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__ . '/../vendor/autoload.php';

// Bootstrap Laravel and handle the request...
(require_once __DIR__ . '/../bootstrap/app.php')
    ->handleRequest(Request::capture());


$target = storage_path('app/public');
$link = public_path('storage');

if (!file_exists($link)) {
    symlink($target, $link);
    echo 'The [public/storage] link has been connected to [storage/app/public].';
} else {
    echo 'The link already exists.';
}
