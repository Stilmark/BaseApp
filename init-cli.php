<?php

if (!defined('ROOT')) {
    define('ROOT', __DIR__);
}
define('WEBROOT', ROOT.'/public');

// Load composer autoloader
if (! @require ROOT.'/vendor/autoload.php') {
    throw new Exception();
}

use Stilmark\Base\Env;

// Load environment variables from .env file
Env::load(ROOT.'/.env');

