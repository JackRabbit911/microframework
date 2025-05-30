<?php

declare(strict_types=1);

namespace Sys;

use DI\ContainerBuilder;

class AppFactory
{
    public static function create(): App
    {
        $builder = new ContainerBuilder();
        $builder->addDefinitions('../vendor/az/src/definisions.php');
        $builder->addDefinitions(APPPATH . 'config/container.php');
        $container = $builder->build();
        $GLOBALS['container'] = $container;
        return $container->get(App::class);
    }
}
