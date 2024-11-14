<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HistoireDuclubController extends AbstractController
{
    #[Route('/histoire-du-club', name: 'app_histoire_duclub')]
    public function index(): Response
    {
        return $this->render('histoire_duclub/index.html.twig');
    }
}
