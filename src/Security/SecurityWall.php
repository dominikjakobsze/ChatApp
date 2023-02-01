<?php

namespace App\Security;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class SecurityWall
{
    public function __construct(private string $secret = '', private string $jwt = '')
    {
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
        $jwtDetails = JWT::decode($this->jwt, new Key($this->secret, 'HS256'));
        dd($jwtDetails);
        return $this;
    }
}