<?php

// Calculate ROOT path relative to this script
define('ROOT', dirname(__DIR__, 2));
require_once ROOT.'/init-cli.php';

use Stilmark\Base\Env;
use FastRoute\RouteCollector;
use FastRoute\cachedDispatcher;

$cacheFile = ROOT . Env::get('ROUTES_CACHE_PATH');

// Ensure cache dir exists (safe in both DEV/PROD)
$cacheDir = dirname($cacheFile);
if (!is_dir($cacheDir)) {
    mkdir($cacheDir, 0775, true);
}

// Compile routes cache file
FastRoute\cachedDispatcher(function(RouteCollector $r) {
    require ROOT . Env::get('ROUTES_PATH');
}, [
    'cacheFile'     => $cacheFile,
    'cacheDisabled' => false, // Force cache generation
]);

echo "Routes cached to $cacheFile" . PHP_EOL;

// Usage
// php bin/build-routes.php
