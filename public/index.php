<?php

declare(strict_types=1);

use Sys\App;
use Sys\Container\Container;

define('APPPATH', '../application/');

require_once '../vendor/autoload.php';

require_once '../vendor/az/src/library.php';

$container = new Container();
$container->addDefinitions();
$app = new App;
$app->run();
