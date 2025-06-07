<?php

declare(strict_types=1);

namespace App\Repository;

use stdClass;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class O2AuthRepo
{
    private array $config;

    public function __construct()
    {
        $this->config = config('o2auth');
    }

    public function generateAccessToken()
    {
        $user = new stdClass;
        $user->id = 1;
        $user->name = 'Алексей';

        return $this->encode($user);
    }

    public function generateRefreshToken()
    {
        $salt = $_SERVER['HTTP_USER_AGENT'] ?? uniqid();
        return sha1($salt.time().bin2hex(random_bytes(16)));
    }

    private function encode(stdClass $user, ?int $iat = null)
    {
        $payload = [
            'iss' => $this->config['iss'],
            'iat' => $iat ?? time(),
            'exp' => $iat + $this->config['lifetime'],
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
            ]
        ];

        return JWT::encode($payload, $this->config['key'], $this->config['algo']);
    }

    private function decode(string $jwt)
    {
        try {
            return JWT::decode($jwt, new Key($this->config['key'], $this->config['algo']));
        } catch (Throwable $e) {
            return null;
        }
    }
}
