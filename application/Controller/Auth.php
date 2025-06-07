<?php

declare(strict_types=1);

namespace App\Controller;

use App\Middleware\AuthValidation;
use Sys\Controller\BaseController;
use Az\Route\Route;
use HttpSoft\Response\JsonResponse;

class Auth extends BaseController
{
    public function __construct(){}

    #[Route(methods: ['post', 'get'])]
    #[AuthValidation]
    public function login()
    {
        return new JsonResponse([
            'success' => true,
            'Bearer' => '$jwt',
            'Refresh' => '$refresh,'
        ]);
    }

    #[Route(methods: 'delete')]
    public function logout()
    {

    }
}
