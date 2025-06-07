<?php

declare(strict_types=1);

namespace App\Controller;

use App\Middleware\AuthValidation;
use App\Repository\O2AuthRepo;
use Sys\Controller\BaseController;
use Az\Route\Route;
use HttpSoft\Response\JsonResponse;

class Auth extends BaseController
{
    public function __construct(){}

    #[Route(methods: ['post', 'get'])]
    // #[AuthValidation]
    public function login(O2AuthRepo $repo)
    {
        return new JsonResponse([
            'success' => true,
            'Bearer' => $repo->generateAccessToken(),
            'Refresh' => $repo->generateRefreshToken(),
        ]);
    }

    #[Route(methods: 'delete')]
    public function logout()
    {

    }
}
