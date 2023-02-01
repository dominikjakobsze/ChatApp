<?php

namespace App\Controller;

use App\Form\LoginForm;
use App\Form\RegisterForm;
use App\Security\SecurityWall;
use App\Service\JWTService;
use App\Service\LoginService;
use App\Service\RegisterService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;

class AuthController extends AbstractController
{
    public function __construct(private SecurityWall $security)
    {
    }

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

    /**
     * @param Request $request
     * @param LoginService $loginService
     * @param JWTService $JWTService
     * @return JsonResponse
     */
    #[Route('/api/login', name: 'AuthController_loginUser', methods: ['POST'])]
    public function loginUser(Request $request, LoginService $loginService, JWTService $JWTService): JsonResponse
    {
//        $this->security->setKey($this->getParameter('app.jwt'))
//            ->setJwt($request->headers->get('JWT-Authorization'))
//            ->isLogged()
//            ->isExpDateValid()
//            ->getAuth();
        $form = $this->createForm(LoginForm::class, null, [
            'csrf_protection' => false
        ]);
        $form->handleRequest($request)->submit($request->request->all());
        if ($form->isSubmitted() && $form->isValid()) {
            $auth = $loginService->getUserFromEmail($form->getData()['email']);
            $loginService->validatePassword($auth, $form->getData()['password']);
            $jwt = $JWTService->generateTokenWithUserInfo($auth, $this->getParameter('app.jwt'));
            return $this->json([
                "message" => "User logged in successfully",
                "jwt" => $jwt
            ], 200);
        }
        throw new BadRequestHttpException("Email or password is invalid");
    }
}