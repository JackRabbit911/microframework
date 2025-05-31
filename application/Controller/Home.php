<?php

declare(strict_types=1);

namespace App\Controller;

use HttpSoft\Response\JsonResponse;
use Sys\Controller\BaseController;

class Home extends BaseController
{
    public function __invoke()
    {
        return new JsonResponse(['bar' => 'foo', 'foo' => 'bar']);
    }

    public function foo($id = 'bar')
    {
        return new JsonResponse(['id' => $id]);
    }
}
