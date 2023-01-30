<?php

namespace App\Controller;

use App\Form\RegisterForm;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;

class AuthController extends AbstractController
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    #[Route('/api/register', name: 'AuthController_registerUser', methods: ['POST'])]
    public function registerUser(Request $request): JsonResponse
    {
        $form = $this->createForm(RegisterForm::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            return $this->json([
                "ok" => "ok"
            ]);
        }

        throw new BadRequestHttpException("Email or password is invalid");
    }
}