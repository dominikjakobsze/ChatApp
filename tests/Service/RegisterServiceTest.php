<?php

namespace App\Tests\Service;

use App\Repository\AuthRepository;
use App\Service\RegisterService;
use PHPUnit\Framework\TestCase;

class RegisterServiceTest extends TestCase
{
    private $registerService;
    private $authRepositoryMock;

    public function setUp(): void
    {
        $this->authRepositoryMock = $this->createMock(AuthRepository::class);
        $this->registerService = new RegisterService($this->authRepositoryMock);
    }

    public function testEmailExists(): void
    {
        $email = "dominik@wp.pl";
        $this->authRepositoryMock->method('findOneBy')->with(['email' => $email])->willReturn(null);
        $this->assertFalse($this->registerService->checkIfEmailIsTaken($email));
    }
}
