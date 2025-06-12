<?php

declare(strict_types=1);

namespace App\Controller;

use App\Middleware\AuthValidation;
use App\Model\ModelAuth;
use App\Model\ModelRefreshToken;
use App\Repository\O2AuthRepo;
use Sys\Controller\BaseController;
use Az\Route\Route;
use HttpSoft\Response\EmptyResponse;
use HttpSoft\Response\JsonResponse;

class Auth extends BaseController
{
    public function __construct(){}

    #[Route(methods: ['post', 'get'])]
    #[AuthValidation]
    public function login(ModelAuth $model, O2AuthRepo $repo)
    {
        $user = $model->get();

        return new JsonResponse([
            'success' => true,
            'Bearer' => $repo->encodeJWT($user),
            'Refresh' => $repo->createRefreshToken($user->id),
            'user' => $user,
        ]);
    }

    #[Route(methods: 'delete')]
    public function logout(ModelRefreshToken $model)
    {
        $data = $this->request->getBody()->getContents();
        $token = json_decode($data)->token;
        $model->delete($token);
        return new EmptyResponse(205);
    }
}
