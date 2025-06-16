<?php

declare(strict_types=1);

namespace Sys\Pagination;

use Psr\Http\Message\ServerRequestInterface;
use Exception;

class Pagination implements PaginationInterface
{
    private int $limit;
    private int $currentPage;
    private int $countPages;
    private string $path;
    private array $queryParams;

    public function __construct(
        ServerRequestInterface $request,
        int $countRows,
    )
    {
        $this->queryParams = $request->getQueryParams();
        $this->currentPage = $this->queryParams['page'] ?? 1;
        $this->limit = $this->queryParams['limit'] ?? 0;
        $this->countPages = (int) ceil($countRows/$this->limit);
        $this->path = rtrim($request->getUri()->getPath(), '/');
    }

    public function count(): int
    {
        return $this->countPages;
    }

    public function offset(): int
    {
        static $offset;

        if ($offset !== null) {
            return $offset;
        }

        $offset = ((int) $this->currentPage - 1) * $this->limit;

        if ($offset < 0) {
            throw new Exception("Offset cannot take a negative value ($offset)");
        }

        return $offset;
    }

    public function current(int $shift = 0): string|null
    {
        $page = $this->currentPage + $shift;
        return $page > 0 && $page <= $this->countPages
            ? $this->uri($page) : null;
    }

    public function prev(int $minus = 0): string|null
    {
        $page = $this->currentPage - 1 - $minus;
        return $this->isValid($page) ? $this->uri($page) : null;
    }

    public function next(int $plus = 0): string|null
    {
        $page = $this->currentPage + 1 + $plus;
        return $this->isValid($page) ? $this->uri($page) : null;
    }

    public function first(int $plus = 0): string|null
    {
        $page = 1 + $plus;
        return $this->isValid($page) ? $this->uri($page) : null;
    }

    public function last(int $minus = 0): string|null
    {
        $page = $this->countPages - $minus;
        return $this->isValid($page) ? $this->uri($page) : null;
    }

    public function page(int $page): string|null
    {
        return $page > 0 && $page <= $this->countPages
            ? $this->uri($page) : null;
    }

    private function isValid(int $page): bool
    {
        return $page > 0 && $page <= $this->countPages && $page !== $this->currentPage;
    }

    private function uri(int $page): string
    {
        $this->queryParams['page'] = $page;

        return $this->path . '?' . http_build_query($this->queryParams);
    }
}
