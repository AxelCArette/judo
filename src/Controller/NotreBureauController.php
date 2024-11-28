<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class NotreBureauController extends AbstractController
{
    #[Route('/notre-equipe', name: 'app_notre_bureau')]
    public function index(): Response
    {
        return $this->render('notre_bureau/index.html.twig');
    }
}
