<?php

namespace App\Tests\Service;

use App\Entity\Auth;
use App\Repository\AuthRepository;
use App\Service\JWTService;
use PHPUnit\Framework\TestCase;

class JWTServiceTest extends TestCase
{
    private JWTService $jwtService;
    private AuthRepository $authRepositoryMock;

    public function setUp(): void
    {
        $this->authRepositoryMock = $this->createMock(AuthRepository::class);
        $this->jwtService = new JWTService($this->authRepositoryMock);
    }

    public function testGenerateTokenWithUserInfo(): void
    {
        $auth = $this->createMock(Auth::class);
        $auth->method('getId')->willReturn(3);
        $jwt = $this->jwtService->generateTokenWithUserInfo($auth, 'secret');
        $this->assertIsString($jwt);
    }
}
