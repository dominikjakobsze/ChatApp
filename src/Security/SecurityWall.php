<?php

namespace App\Security;

use App\Entity\Auth;
use App\Repository\AuthRepository;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class SecurityWall
{
    private AuthRepository $authRepository;
    private string $secret;
    private string|array $jwt;
    private Auth $auth;

    public function __construct(AuthRepository $authRepository)
    {
        $this->authRepository = $authRepository;
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
        //cache results
        $jwtDetails = JWT::decode($this->jwt, new Key($this->secret, 'HS256'));
        $this->jwt = (array)$jwtDetails;
        $this->auth = $this->authRepository->findOneBy(['id' => ((array)$jwtDetails)['user_id']]);
        return $this;
    }

    public function isExpDateValid(): self
    {
        $now = new \DateTimeImmutable();
        $now = $now->getTimestamp();
        if ($this->jwt['exp'] < $now) {
            throw new BadRequestHttpException("JWT expired");
        }
        return $this;
    }

    public function getAuth(): Auth
    {
        return $this->auth;
    }
}