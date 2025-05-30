<?php

declare(strict_types=1);

namespace Sys;

use DI\ContainerBuilder;

class AppFactory
{
    public static function create(): App
    {
        $builder = new ContainerBuilder();
        $builder->addDefinitions('../vendor/az/src/container.php');
        $container = $builder->build();
        return $container->get(App::class);
    }
}
