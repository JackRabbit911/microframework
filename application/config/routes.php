<?php

use App\Controller\Home;
use HttpSoft\Response\JsonResponse;

return [
    'home'      => ['/', Home::class],
    'auth'      => ['/auth/{id?}', fn($id = 'kuku') => new JsonResponse(['id' => $id])],
];
