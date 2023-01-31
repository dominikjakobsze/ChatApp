<?php

namespace App\Controller;

use App\Form\RegisterForm;
use App\Service\RegisterService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;

class AuthController extends AbstractController
{
    /**
     * @param Request $request
     * @param RegisterService $registerService
     * @return JsonResponse
     */
    #[Route('/api/register', name: 'AuthController_registerUser', methods: ['POST'])]
    public function registerUser(Request $request, RegisterService $registerService): JsonResponse
    {
        $form = $this->createForm(RegisterForm::class, null, [
            'csrf_protection' => false
        ]);
        $form->handleRequest($request)->submit($request->request->all());
        if ($form->isSubmitted() && $form->isValid()) {
            $registerService->checkIfEmailIsTaken($form->getData()['email']);
            $registerService->createNewUser($form->getData()['email'], $form->getData()['password']);
            return $this->json([
                "message" => "User registered successfully"
            ], 200);
        }

        throw new BadRequestHttpException("Email or password is invalid");
    }

    #[Route('/api/login', name: 'AuthController_loginUser', methods: ['POST'])]
    public function loginUser(Request $request)
    {
        return $this->json(true);
    }
}