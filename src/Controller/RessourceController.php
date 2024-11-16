<?php

namespace App\Controller;

use App\Repository\RessourceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RessourceController extends AbstractController
{
    #[Route('/ressource', name: 'app_ressource')]
    public function index(RessourceRepository $ressourceRepository): Response
    {
        // Récupérer toutes les ressources publiées
        $ressources = $ressourceRepository->findBy(['Publier' => true], ['datetime' => 'DESC']);
        
        // Regrouper les ressources par grade
        $ressourcesParGrade = [];
        foreach ($ressources as $ressource) {
            $grade = $ressource->getGrade() ?? 'Inconnu';
            $ressourcesParGrade[$grade][] = $ressource;
        }

        // Passer les ressources à la vue
        return $this->render('ressource/index.html.twig', [
            'ressourcesParGrade' => $ressourcesParGrade,
        ]);
    }
}
