<?php

use App\Controller\File;
use App\Controller\Home;
use HttpSoft\Response\JsonResponse;

return [
    'auth'      => ['/auth/{id?}', fn($request) => new JsonResponse(['id' => $request->getAttribute('foo')])],
    'file'      => ['/file/{file}', File::class, ['file' => '.*']],
    'home'      => ['/{action?}/{id?}', Home::class],
];
