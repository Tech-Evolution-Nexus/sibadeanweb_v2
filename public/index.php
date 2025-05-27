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


$target = __DIR__ . '/../storage/app/public';
$link = __DIR__ . '/../public/storage';

if (!file_exists($link)) {
    symlink($target, $link);
    echo '✅ Symbolic link created: public/storage → storage/app/public';
} else {
    echo 'ℹ️ Symbolic link already exists.';
}
