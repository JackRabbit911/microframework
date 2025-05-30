<?php

declare(strict_types=1);

namespace Sys;

use Sys\Container\Container;

class AppFactory
{
    public static function create(): App
    {
        $container = new Container();
        $container->addDefinitions('../vendor/az/src/Container/config.php');
        return $container->get(App::class);
    }
}
