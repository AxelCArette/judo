<?php
namespace App\Controller;

use App\Repository\SponsorsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SponsorsController extends AbstractController
{
    #[Route('/sponsors', name: 'app_sponsors')]
    public function index(SponsorsRepository $sponsorsRepository): Response
    {
        // Récupérer uniquement les sponsors publiés
        $sponsors = $sponsorsRepository->findBy(['publier' => true]);

        // Rendre la vue Twig et passer les sponsors publiés
        return $this->render('sponsors/index.html.twig', [
            'sponsors' => $sponsors,
        ]);
    }
}

