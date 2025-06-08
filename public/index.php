<?php

declare(strict_types=1);

use Sys\AppFactory;

define('APPPATH', '../application/');
define('SYSPATH', '../vendor/az/src/');

require_once '../vendor/az/src/exceptionHandler.php';
require_once '../vendor/az/src/autoload.php';
require_once '../vendor/autoload.php';
require_once '../vendor/az/src/library.php';
require_once APPPATH . 'config/bootstrap.php';

AppFactory::create()->run();
