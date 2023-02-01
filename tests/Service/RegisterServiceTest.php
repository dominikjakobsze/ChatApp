<?php

namespace App\Tests\Service;

use App\Repository\AuthRepository;
use App\Service\RegisterService;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class RegisterServiceTest extends TestCase
{
    private RegisterService $registerService;
    private AuthRepository $authRepositoryMock;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->authRepositoryMock = $this->createMock(AuthRepository::class);
        $this->registerService = new RegisterService($this->authRepositoryMock);
    }

    /**
     * @return void
     */
    public function testEmailDoesNotExist(): void
    {
        $email = "dominik@wp.pl";
        $this->authRepositoryMock->method('findOneBy')->with(['email' => $email])->willReturn(null);
        $this->assertFalse($this->registerService->checkIfEmailIsTaken($email));
    }

    /**
     * @return void
     */
    public function testEmailExists(): void
    {
        $email = "dominik@wp.pl";
        $this->authRepositoryMock->method('findOneBy')->with(['email' => $email])->willReturn(true);
        $this->expectException(BadRequestHttpException::class);
        $this->registerService->checkIfEmailIsTaken($email);
    }
}
