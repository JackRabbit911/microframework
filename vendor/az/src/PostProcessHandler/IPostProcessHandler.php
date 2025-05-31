<?php

declare(strict_types=1);

namespace Sys\PostProcessHandler;

use Psr\Http\Message\ResponseInterface;

interface IPostProcessHandler
{
    public function handle(ResponseInterface $response): ResponseInterface;
}
