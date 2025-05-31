<?php

declare(strict_types=1);

namespace Sys;

use HttpSoft\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class DefaultHandler implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return new JsonResponse(['status' => 404, 'msg' => 'Page not found'], 404);
    }
}
