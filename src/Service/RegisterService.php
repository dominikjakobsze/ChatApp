<?php

namespace App\Service;

use App\Entity\Auth;
use App\Repository\AuthRepository;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class RegisterService
{
    /**
     * @param AuthRepository $authRepository
     */
    public function __construct(private AuthRepository $authRepository)
    {
    }

    /**
     * @param string $email
     * @return bool
     */
    public function checkIfEmailIsTaken(string $email): bool
    {
        if ($this->authRepository->findOneBy(['email' => $email]) == null) {
            return false;
        }
        throw new BadRequestHttpException("Email is already taken");
    }

    /**
     * @param string $email
     * @param string $password
     * @return void
     */
    public function createNewUser(string $email, string $password): void
    {
        $auth = new Auth();
        $auth->setEmail($email);
        $auth->setPassword(password_hash($password, PASSWORD_BCRYPT));
        $this->authRepository->save($auth, true);
    }
}