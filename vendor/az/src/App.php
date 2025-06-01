<?php

declare(strict_types=1);

namespace Sys;

use Sys\Pipeline\PipelineInterface;
use Az\Route\Middleware\RouteDispatch;
use Az\Route\Middleware\RouteMatch;
use HttpSoft\Emitter\EmitterInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Sys\Middleware\ControllerAttribute;
use Sys\Pipeline\PostProcess;

class App
{
    public function __construct(
        private ServerRequestInterface $request,
        private PipelineInterface $pipeline,
        private RequestHandlerInterface $defaultHandler,
        private PostProcess $postProcess,
        private EmitterInterface $emitter
    ){}

    public function run()
    {
        require_once APPPATH . 'config/pipeline.php';
        $this->pipeline->pipe(RouteMatch::class);
        $this->pipeline->pipe(ControllerAttribute::class);
        $this->pipeline->pipe(RouteDispatch::class);

        $response = $this->pipeline->process($this->request, $this->defaultHandler);
        $response = $this->postProcess->process($response);

        $this->emitter->emit($response);
    }
}
