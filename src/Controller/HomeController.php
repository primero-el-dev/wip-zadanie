<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/{path<(?!api).*>}', name: 'app_home')]
    public function index(?string $path): Response
    {
        return $this->render('base.html.twig');
    }
}
