<?php

declare(strict_types=1);

namespace Sys\PostProcessHandler;

interface ObserverInterface extends IPostProcessHandler
{
    public function update(object $object): void;
}
