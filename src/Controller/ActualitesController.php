<?php

namespace App\Controller;

use App\Entity\Actualites;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ActualitesController extends AbstractController
{
    #[Route('/actualites', name: 'app_actualites')]
    public function index(EntityManagerInterface $em): Response
    {
        // Récupérer les actualités publiées
        $actualites = $em->getRepository(Actualites::class)
                        ->findBy(['publier' => true], ['datePublication' => 'DESC']);

        return $this->render('actualites/index.html.twig', [
            'actualites' => $actualites
        ]);
    }

    #[Route('/actualites/{id}', name: 'app_actualite_detail')]
    public function detail(Actualites $actualite): Response
    {
        // Vérifier si l'actualité existe, sinon afficher une page 404
        if (!$actualite) {
            throw $this->createNotFoundException('Actualité non trouvée');
        }

        return $this->render('actualites/detail.html.twig', [
            'actualite' => $actualite
        ]);
    }
}
