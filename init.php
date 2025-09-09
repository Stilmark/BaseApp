<?php

$session_timeout = 24 * 3600;

ini_set( "session.gc_maxlifetime", $session_timeout );

session_start();

define('ROOT', __DIR__);
define('WEBROOT', ROOT.'/public');

// Load composer autoloader
if (! @require ROOT.'/vendor/autoload.php') {
    throw new Exception();
}

use Stilmark\Base\Env;
use Stilmark\Base\Router;

// Load environment variables from .env file
Env::load(ROOT.'/.env');

Router::init();
