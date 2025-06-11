<?php

declare(strict_types=1);

// use App\Middleware\MockRequest;
use Sys\Middleware\CORS;

// $this->pipeline->pipe(MockRequest::class);
$this->pipeline->pipe(CORS::class);
