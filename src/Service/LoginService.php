<?php

namespace App\Service;

use App\Entity\Auth;
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
     * @return Auth
     */
    public function getUserFromEmail(string $email): Auth
    {
        $auth = $this->authRepository->findOneBy(['email' => $email]);
        if ($auth == null) {
            throw new BadRequestHttpException("Such email does not exist");
        }
        return $auth;
    }
}