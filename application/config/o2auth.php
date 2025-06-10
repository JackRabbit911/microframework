<?php

return [
    'algo' => 'HS256',
    'key' => env('OAUTH_KEY'),
    'lifetime' => 30,
    'iss' => env('APP_NAME'),
    'refresh_lifetime' => 3600 * 4,
    'refresh_update' => 3600,
];
