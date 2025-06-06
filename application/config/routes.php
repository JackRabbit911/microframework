<?php

use App\Controller\File;
use App\Controller\Home;
use HttpSoft\Response\JsonResponse;
use Sys\Console\Controller as ConsoleController;

return [
    'console'   => ['/console/{model}/{method}', ConsoleController::class, ['model' => '[\w\/]+']],
    'auth'      => ['/auth/{id?}', fn($request) => new JsonResponse(['id' => $request->getAttribute('foo')])],
    'file'      => ['/file/{file}', File::class, ['file' => '.*']],
    'home'      => ['/{action?}/{id?}', Home::class],
];
