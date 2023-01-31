<?php

namespace App\Service;

use Firebase\JWT\JWT;

class JWTService
{
    public function __construct(private JWT $jwt)
    {
    }

}