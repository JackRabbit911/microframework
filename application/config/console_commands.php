<?php

declare(strict_types=1);

use Symfony\Component\Console\Command\Command;
use Sys\Console\Command\Make\Controller;
use Sys\Console\Command\Make\Database;
use Sys\Console\Command\Make\MakeCommand;
use Sys\Console\Command\Make\Middleware;
use Sys\Console\Command\Make\Model;
use Sys\Console\Command\Make\Validation;

return [
    'make:command' => static fn(): Command => $container->get(MakeCommand::class),
    'mk:cmd' => static fn(): Command => $container->get(MakeCommand::class),

    'make:controller' => static fn(): Command => $container->get(Controller::class),
    'mk:ctrl' => static fn(): Command => $container->get(Controller::class),

    'make:middleware' => static fn(): Command => $container->get(Middleware::class),
    'mk:mw' => static fn(): Command => $container->get(Middleware::class),

    'make:validation' => static fn(): Command => $container->get(Validation::class),
    'mk:valid' => static fn(): Command => $container->get(Validation::class),

    'make:model' => static fn(): Command => $container->get(Model::class),

    'make:database' => static fn(): Command => $container->get(Database::class),
    'mk:db' => static fn(): Command => $container->get(Database::class),
];
