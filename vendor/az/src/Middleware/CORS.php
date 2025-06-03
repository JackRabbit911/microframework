<?php

declare(strict_types=1);

namespace App\Middleware;

use HttpSoft\Response\EmptyResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Sys\Pipeline\PostProcess;
use Sys\PostProcessHandler\ResponseHeaders;

class CORS implements MiddlewareInterface
{
    public function __construct(private PostProcess $postProcess){}

    public function process(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler
    ): ResponseInterface
    {
        $contract = require_once APPPATH . 'config/api_contract.php';
        $headers = $this->getHeaders($request, $contract);

        $this->postProcess
            ->enqueue(ResponseHeaders::class)
            ->add($headers);
        
        if ($request->getMethod() === 'OPTIONS') {
            return new EmptyResponse(204);
        }

        return $handler->handle($request);
    }

    private function getHeaders($request, $contract)
    {
        $allow_headers = implode(',', $contract['headers']);
        $allow_methods = array_map(fn($v) => strtoupper($v), $contract['methods']);
        $allow_methods = implode(',', $allow_methods);

        $headers = [
            'Access-Control-Allow-Headers' => $allow_headers,
            'Access-Control-Expose-Headers' => $allow_headers,
        ];

        if (in_array($request->getHeaderLine('Origin'), $contract['hosts'])) {
            $headers['Access-Control-Allow-Origin'] = $request->getHeaderLine('Origin');
        }

        $headers['Access-Control-Allow-Methods'] = $allow_methods;

        if (isset($contract['max_age'])) {
            $headers['Access-Control-Max-Age'] = $contract['max_age'];
        }

        if (isset($contract['allow_credentials']) && $contract['allow_credentials'] === true) {
            $headers['Access-Control-Allow-Credentials'] = 'true';
        }

        return $headers;
    }
}
