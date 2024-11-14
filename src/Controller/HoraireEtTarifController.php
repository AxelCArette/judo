<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HoraireEtTarifController extends AbstractController
{
    #[Route('/horaire-et-tarif', name: 'app_horaire_et_tarif')]
    public function index(): Response
    {
        return $this->render('horaire_et_tarif/index.html.twig');
    }
}
