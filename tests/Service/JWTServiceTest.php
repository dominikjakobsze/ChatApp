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

    public function testUserInfoIsReturnedNotOk(): void
    {
        $auth = $this->createMock(Auth::class);
        $auth->method('getId')->willReturn(2);
        $jwt = $this->jwtService->generateTokenWithUserInfo($auth, 'secret');
        $this->authRepositoryMock->method('findOneBy')->willReturn(null);
        $user = $this->jwtService->getUserFromToken($jwt, 'secret');
        $this->assertArrayHasKey('exp', $user);
        $this->assertArrayHasKey('user', $user);
        $this->assertNull($user['user']);
        $this->assertNotNull($user['exp']);
    }

    public function testUserInfoIsReturnedOk(): void
    {
        $auth = $this->createMock(Auth::class);
        $auth->method('getId')->willReturn(2);
        $jwt = $this->jwtService->generateTokenWithUserInfo($auth, 'secret');
        $this->authRepositoryMock->method('findOneBy')->willReturn(new Auth());
        $user = $this->jwtService->getUserFromToken($jwt, 'secret');
        $this->assertArrayHasKey('exp', $user);
        $this->assertArrayHasKey('user', $user);
        $this->assertNotNull($user['user']);
        $this->assertNotNull($user['exp']);
    }
}
