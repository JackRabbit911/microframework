<?php

declare(strict_types=1);

namespace App\Middleware;

use HttpSoft\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class CORS implements MiddlewareInterface
{
    public function __construct(private string $foo = 'BAR'){}

    public function process(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler
    ): ResponseInterface
    {
        return new JsonResponse(['foo' => $this->foo]);
    }
}
