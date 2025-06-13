<?php

declare(strict_types=1);

namespace App\Middleware;

use App\DTO\User;
use App\Enum\TokenType;
use App\Model\ModelAuth;
use App\Repository\O2AuthRepo;
use HttpSoft\Response\EmptyResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Sys\PostProcessHandler\ResponseHeaders;

class O2AuthGuard implements MiddlewareInterface
{
    public function __construct(
        private O2AuthRepo $repo,
        private ModelAuth $modelAuth,
        private ResponseHeaders $responseHeaders
    ){}

    public function process(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler
    ): ResponseInterface
    {
        if ($this->exceptUri($request)) {
            return $handler->handle($request);
        }

        $token = $request->getHeaderLine('Authorization');

        if ($token) {
            $token_type = TokenType::detect($token);

            if ($token_type === TokenType::Bearer) {
                $result = $this->checkBearer($token);

                if ($result instanceof ResponseInterface) {
                    return $result;
                }

                $request = $request->withAttribute('user', $result);
            } elseif ($token_type === TokenType::Refresh) {
                $result = $this->checkRefresh($token);

                if ($result instanceof ResponseInterface) {
                    return $result;
                } else {
                    $this->responseHeaders->add(['X-Bearer' => $result]);
                }
            } else {
                return new EmptyResponse(401);
            }
        } else {
            return new EmptyResponse(401);
        }

        return $handler->handle($request);
    }

    private function checkBearer(string $token): User|ResponseInterface
    {
        $token = str_replace('Bearer ', '', $token);
        $result = $this->repo->decodeJWT($token);

        return match ($result) {
            true => new EmptyResponse(204, ['X-Refresh' => '']),
            false => new EmptyResponse(401),
            default => User::fromObject($result->user),
        };
    }

    private function checkRefresh(string $token): string|ResponseInterface
    {
        $token = str_replace('Refresh ', '', $token);
        $result = $this->repo->checkRefreshToken($token);

        if ($result) {
            if ($result->token !== $token) {
                 $this->responseHeaders->add(['X-Refresh' => $result->token]);
            }

            $user = $this->modelAuth->find($result->user_id);
            return $this->repo->encodeJWT($user);
            
        } else {
            return new EmptyResponse(401);
        }
    }

    private function exceptUri(ServerRequestInterface $request)
    {
        $uri = $request->getUri()->getPath();
        
        if (in_array($uri, config('o2auth', 'exclude_urls'))) {
            return true;
        }

        return false;
    }
}
