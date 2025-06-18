<?php

namespace Tests\Sys\Pipeline;

use Sys\Pipeline\PostProcess;
use PHPUnit\Framework\TestCase;
use HttpSoft\Message\Response;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Sys\PostProcessHandler\IPostProcessHandler;

class PostProcessTest extends TestCase
{
    public function testPostProcess()
    {
        $container = $this->createStub(ContainerInterface::class);
        $cut = new PostProcess($container);
        $response = new Response(200);

        $handler1 = $this->getHandler('Foo');
        $handler2 = $this->getHandler('Bar');

        $handler1 = $cut->enqueue($handler1);
        $handler2 = $cut->enqueue($handler2);

        $response = $cut->process($response);

        $this->assertInstanceOf(IPostProcessHandler::class, $handler1);
        $this->assertTrue($response->hasHeader('X-Postprocess'));
        $this->assertSame('Foo,Bar', $response->getHeaderLine('X-Postprocess'));
    }

    private function getHandler(string $headerValue): object
    {
        return new class ($headerValue) implements IPostProcessHandler
        {
            public function __construct(private string $headerValue){}

            public function handle(ResponseInterface $response): ResponseInterface
            {
                return $response->withAddedHeader('X-Postprocess', $this->headerValue);
            }
        };
    }
}
