<?php

namespace Sys\Controller;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Az\Route\Route;

abstract class BaseController implements RequestHandlerInterface
{
    protected ServerRequestInterface $request;
    protected array $parameters;

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $this->request = $request;
        $route = $request->getAttribute(Route::class);
        $this->parameters = $route->getParameters();

        [$handler, $action] = $route->getHandler();

        $this->_before();
        $response = $this->call($action, $this->parameters);

        return $response;
    }

    protected function _before() {}

    private function call(string $action, array $attr = [])
    {
        $container = container();

        if ($container && method_exists($container, 'call')) {
            return $container->call([$this, $action], $attr);
        }
            
        return call_user_func_array([$this, $action], $attr);
    }
}
