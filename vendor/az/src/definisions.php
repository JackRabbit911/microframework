<?php

use Az\Route\Router;
use Az\Route\RouterInterface;
use HttpSoft\Emitter\EmitterInterface;
use HttpSoft\Emitter\SapiEmitter;
use HttpSoft\ServerRequest\ServerRequestCreator;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Sys\DefaultHandler;
use Sys\Pipeline\Pipeline;
use Sys\Pipeline\PipelineInterface;

return [
    ServerRequestInterface::class => (new ServerRequestCreator)->create(),
    PipelineInterface::class => fn(ContainerInterface $c) => new Pipeline($c),
    RouterInterface::class => new Router(ROUTES),
    RequestHandlerInterface::class => new DefaultHandler,
    EmitterInterface::class => new SapiEmitter(),
];
