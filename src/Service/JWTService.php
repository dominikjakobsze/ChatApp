<?php

namespace App\Service;

use App\Entity\Auth;
use App\Repository\AuthRepository;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class JWTService
{
    private AuthRepository $authRepository;

    public function __construct(AuthRepository $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    /**
     * @param Auth $auth
     * @param $key
     * @return string
     */
    public function generateTokenWithUserInfo(Auth $auth, $key): string
    {
        $exp = new \DateTimeImmutable();
        $exp = $exp->modify('+1 day')->getTimestamp();
        $payload = [
            'exp' => $exp,
            'user_id' => $auth->getId(),
        ];
        return JWT::encode($payload, $key, 'HS256');
    }

    public function getUserFromToken(string $jwt, $secret): array
    {
        $jwtDetails = JWT::decode($jwt, new Key($secret, 'HS256'));
        return [
            'exp' => ((array)$jwtDetails)['exp'],
            'user' => $this->authRepository->findOneBy(['id' => ((array)$jwtDetails)['user_id']])
        ];
    }

    public function isTokenExpired(string $date): bool
    {
        $now = new \DateTimeImmutable();
        $now = $now->getTimestamp();
        if ((int)$date < $now) {
            throw new BadRequestHttpException("JWT expired");
        }
        return true;
    }

}