<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AuthController extends AbstractController
{
    #[Route('/api/register', name: 'AuthController_registerUser', methods: ['POST'])]
    public function registerUser(Request $request): JsonResponse
    {
        return $this->json([
            "register" => "user"
        ]);
    }
}