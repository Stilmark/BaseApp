<?php

// Disable all cache
header('Cache-Control: no-store, no-cache, must-revalidate, private'); // HTTP/1.1
header('Pragma: no-cache'); //HTTP 1.0
header('Expires: Sat, 26 Jul 1997 05:00:00 GMT'); // Date in the past

## Init
require __DIR__.'/../init.php';