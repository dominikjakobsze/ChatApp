<?php

namespace App\Service;

use App\Entity\Auth;
use Firebase\JWT\JWT;

class JWTService
{
    /**
     * @param Auth $auth
     * @param $key
     * @return string
     */
    public function generateTokenWithUserInfo(Auth $auth, $key): string
    {
        $jwt = new JWT();
        $exp = new \DateTimeImmutable();
        $exp = $exp->modify('+1 day')->getTimestamp();
        $payload = [
            'exp' => $exp,
            'user_id' => $auth->getId(),
        ];
        return JWT::encode($payload, $key, 'HS256');
    }

}