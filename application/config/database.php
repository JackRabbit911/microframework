<?php

return [
    'mysql' => [
        'driver' => env('DB_DRIVER'),
        'host' => env('DB_HOST'),
        'database' => env('DB_DATABASE'),
        'username' => env('DB_USERNAME'),
        'password' => env('DB_PASSWORD'),
        'charset' => env('DB_CHARSET'),
    ],
];
