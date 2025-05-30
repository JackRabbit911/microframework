<?php

return [
    'hosts' => [
        'localhost',
        'localhost:3000',
        'localhost:5500',
        'localhost:5173',
    ],
    'headers' => [
        'Authorization',
        'X-Token',
    ],
    'methods' => [
        'get',
        'post',
        'delete',
        'patch',
    ],
    'max_age' => 30,
    'allow_credentials' => true,
];
