<?php

namespace App\Service;

use App\Repository\AuthRepository;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class LoginService
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
    public function getUserFromEmail(string $email): bool
    {
        if ($this->authRepository->findOneBy(['email' => $email]) == null) {
            throw new BadRequestHttpException("Such email does not exist");
        }
        return true;
    }
}