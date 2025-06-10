<?php

declare(strict_types=1);

namespace App\Middleware;

use GuzzleHttp\Psr7\ServerRequest;
// use HttpSoft\Message\ServerRequest;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class MockRequest implements MiddlewareInterface
{
    public function process(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler
    ): ResponseInterface
    {
        $data = [
            'email' => 'aa@qq.qq',
            'password' =>'qaz',
        ];

        $body = json_encode($data);

        $headers = [
            'Accept-Language' => 'ru',
            'Content-Type' => 'application/json',
        ];

        $request = new ServerRequest('POST', '/auth/login', $headers, $body);
        return $handler->handle($request);
    }
}
