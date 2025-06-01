<?php

declare(strict_types=1);

namespace Sys\Console\Command\Make;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputArgument;

#[AsCommand(name: 'make:command', aliases: ['mk:cmd'])]
class MakeCommand extends MakeAbstract
{
    protected string $folder = 'command';
    protected string $blank = 'command';

    protected function configure(): void
    {
        $this
            ->setDescription('Creates a new command.')
            ->setHelp('This command allows you to create a new command...')
            ->addArgument('name', InputArgument::REQUIRED, 'command name')
        ;
    }
}
