<?php

declare(strict_types=1);

use Sys\Middleware\CORS;

$this->pipeline->pipe(CORS::class);
