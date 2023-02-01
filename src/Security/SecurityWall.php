<?php

namespace App\Security;

use App\Entity\Auth;
use App\Repository\AuthRepository;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class SecurityWall
{
    private AuthRepository $authRepository;
    private string $secret;
    private string $jwt;
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
        //check if expired using ((array)$jwtDetails)['exp']
        $date = new \DateTimeImmutable();
        dd(((array)$jwtDetails)['exp'], $date->getTimestamp());
        $this->auth = $this->authRepository->findOneBy(['id' => ((array)$jwtDetails)['user_id']]);
        return $this;
    }
}