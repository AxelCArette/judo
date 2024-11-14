<?php
namespace App\Controller;

use App\Repository\SponsorsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Filesystem\Filesystem;

class SponsorsController extends AbstractController
{
    #[Route('/sponsors', name: 'app_sponsors')]
    public function index(SponsorsRepository $sponsorsRepository): Response
    {
        $sponsors = $sponsorsRepository->findBy(['publier' => true]);
        $filesystem = new Filesystem();
        
        foreach ($sponsors as $sponsor) {
            
            // Vérifier si le logo existe dans le répertoire imagesponsors
            if ($sponsor->getLogoUrl() && !$filesystem->exists('public/asset/img/imagesponsors/' . $sponsor->getLogoUrl())) {
                // Mettre à jour l'URL de l'image (sans inclure public/)
                $sponsor->logoUrl = 'asset/img/imgsponso/' . $sponsor->getLogoUrl();
            }
        }

        return $this->render('sponsors/index.html.twig', [
            'sponsors' => $sponsors,
        ]);
    }
}
