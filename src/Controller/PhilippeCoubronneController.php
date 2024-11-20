<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PhilippeCoubronneController extends AbstractController
{
    #[Route('/philippe-coubronne', name: 'app_philippe_coubronne')]
    public function index(): Response
    {
        return $this->render('philippe_coubronne/index.html.twig');
    }
}
