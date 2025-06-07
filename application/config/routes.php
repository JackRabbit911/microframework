<?php

use App\Controller\Auth;
use App\Controller\File;
use App\Controller\Home;
use HttpSoft\Response\JsonResponse;
use Sys\Console\Controller as ConsoleController;

return [
    'console'   => ['/console/{model}/{method}', ConsoleController::class, ['model' => '[\w\/]+']],
    'auth'      => ['/auth/{action}', Auth::class],
    'file'      => ['/file/{file}', File::class, ['file' => '.*']],
    'home'      => ['/{action?}/{id?}', Home::class],
];
