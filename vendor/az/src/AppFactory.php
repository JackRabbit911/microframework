<?php

declare(strict_types=1);

namespace Sys;

use DI\ContainerBuilder;
use Psr\Container\ContainerInterface;

class AppFactory
{
    public static function create(): App
    {
        $container = self::getContainer();
        return $container->get(App::class);
    }

    public static function getContainer(): ContainerInterface
    {
        $builder = new ContainerBuilder();
        $builder->addDefinitions(SYSPATH . 'definisions.php');
        $builder->addDefinitions(APPPATH . 'config/container.php');
        $container = $builder->build();
        $GLOBALS['container'] = $container;
        return $container;
    }
}
