<?php

namespace App\Security;

use App\Entity\Auth;
use App\Repository\AuthRepository;
use App\Service\JWTService;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class SecurityWall
{
    private AuthRepository $authRepository;
    private string $secret;
    private string|array $jwt;
    private string $exp;
    private Auth $auth;
    private JWTService $jwtService;

    public function __construct(AuthRepository $authRepository, JWTService $JWTService)
    {
        $this->authRepository = $authRepository;
        $this->jwtService = $JWTService;
    }

    public function setKey(string $secret): self
    {
        $this->secret = $secret;
        return $this;
    }

    public function setJwt(string $jwt): self
    {
        $this->jwt = $jwt;
        return $this;
    }

    public function isLogged(): self
    {
        $data = $this->jwtService->getUserFromToken($this->jwt, $this->secret);
        $this->exp = $data['exp'];
        $this->auth = $data['user'];
        return $this;
    }

    public function isExpDateValid(): self
    {
        $this->jwtService->isTokenExpired($this->exp);
        return $this;
    }

    public function getAuth(): Auth
    {
        return $this->auth;
    }
}