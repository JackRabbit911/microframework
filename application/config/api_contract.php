<?php

return [
    'hosts' => [
        'http://localhost',
        'http://localhost:3000',
        'http://localhost:5500',
        'http://localhost:5173',
    ],
    'headers' => [
        'Authorization',
        'Content-Type',
        'X-Token',
    ],
    'methods' => [
        'get',
        'post',
        'delete',
        'patch',
    ],
    // 'max_age' => 30,
    'allow_credentials' => true,
];
