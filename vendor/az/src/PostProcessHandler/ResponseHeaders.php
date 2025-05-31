<?php

declare(strict_types=1);

namespace Sys\PostProcessHandler;

// use IPostProcessHandler;
use Psr\Http\Message\ResponseInterface;

class ResponseHeaders implements IPostProcessHandler
{
    private array $headers = [];

    public function add(array $headers)
    {
        $this->headers = array_replace($this->headers, $headers);
    }

    public function handle(ResponseInterface $response): ResponseInterface
    {
        foreach ($this->headers as $name => $value) {
            $response = $response->withAddedHeader($name, $value);
        }

        return $response;
    }
}
