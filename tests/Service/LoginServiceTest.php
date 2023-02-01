<?php

namespace App\Tests\Service;

use App\Entity\Auth;
use App\Repository\AuthRepository;
use App\Service\LoginService;
use PHPUnit\Framework\TestCase;

class LoginServiceTest extends TestCase
{
    private LoginService $loginService;
    private AuthRepository $authRepositoryMock;

    public function setUp(): void
    {
        $this->authRepositoryMock = $this->createMock(AuthRepository::class);
        $this->loginService = new LoginService($this->authRepositoryMock);
    }

    public function testUserFromEmailFound()
    {
        $email = 'dominik@wp.pl';
        $auth = new Auth();
        $this->authRepositoryMock->method('findOneBy')->with(['email' => $email])->willReturn($auth);
        $this->assertEquals($auth, $this->loginService->getUserFromEmail($email));
    }
}
