<?php

declare(strict_types=1);

namespace Sys\Pagination;

use Psr\Http\Message\ServerRequestInterface;

interface PaginationInterface
{
    public function __construct(
        ServerRequestInterface $request,
        int $countRows,
    );

    public function count(): int;
    public function offset(): int;
    public function current(int $shift = 0): string|null;
    public function prev(int $minus = 0): string|null;
    public function next(int $plus = 0): string|null;
    public function first(int $plus = 0): string|null;
    public function last(int $minus = 0): string|null;
    public function page(int $number): string|null;
}
