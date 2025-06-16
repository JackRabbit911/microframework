<?php

declare(strict_types=1);

namespace Tests\Sys\Pagination;

use Sys\Pagination\Pagination;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UriInterface;

final class PaginationTest extends TestCase
{
    private Pagination $pagination;

    public function testCount()
    {
        $this->assertSame(6, $this->pagination->count());
    }

    public function testOffset()
    {
        $this->assertSame(20, $this->pagination->offset());
    }

    public function testCurrent()
    {
        $this->assertSame('/page/users?page=2&limit=20', $this->pagination->current());
        $this->assertNull($this->pagination->current(6));
        $this->assertNull($this->pagination->current(-2));
    }

    public function testPrev()
    {
        $this->assertSame('/page/users?page=1&limit=20', $this->pagination->prev());
        $this->assertNull($this->pagination->prev(1));
    }

    public function testNext()
    {
        $this->assertSame('/page/users?page=3&limit=20', $this->pagination->next());
        $this->assertNull($this->pagination->next(5));
    }

    public function testFirst()
    {
        $this->assertSame('/page/users?page=1&limit=20', $this->pagination->first());
    }

     public function testLast()
    {
        $this->assertSame('/page/users?page=6&limit=20', $this->pagination->last());
    }

    public function testPage()
    {
        $this->assertSame('/page/users?page=6&limit=20', $this->pagination->page(6));
        $this->assertNull($this->pagination->page(7));
    }

    protected function setUp(): void
    {
        $stream = $this->createStub(UriInterface::class);
        $stream->method('getPath')
            ->willReturn('/page/users');

        $request = $this->createStub(ServerRequestInterface::class);
        $request->method('getQueryParams')
            ->willReturn([
                'page' => 2,
                'limit' => 20,
            ]);

        $request->method('getUri')
            ->willReturn($stream);

        $this->pagination = new Pagination($request, 105);
    }
}
