<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @return Response
     */
    #[Route('/{react}', name: 'react_entrypoint', requirements: ['react' => '^(?!api).*$'], defaults: ['react' => null])]
    public function home(): Response
    {
        return $this->render('main.html.twig');
    }
}