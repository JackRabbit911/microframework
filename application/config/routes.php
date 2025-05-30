<?php

use App\Controller\Home;
use HttpSoft\Response\JsonResponse;

return [
    'auth'      => ['/auth/{id?}', fn($request) => new JsonResponse(['id' => $request->getAttribute('foo')])],
    'home'      => ['/{action?}/{id?}', Home::class],
];
