<?php

declare(strict_types=1);

// use App\Middleware\MockRequest;
use App\Middleware\O2AuthGuard;
use Sys\Middleware\CORS;

// $this->pipeline->pipe(MockRequest::class);
$this->pipeline->pipe(CORS::class);
$this->pipeline->pipe(O2AuthGuard::class);
