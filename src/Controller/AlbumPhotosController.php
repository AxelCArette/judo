<?php

namespace App\Controller;

use App\Repository\AlbumRepository;
use App\Repository\PhotosRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AlbumPhotosController extends AbstractController
{
    // Affiche tous les albums publiés
    #[Route('/albums', name: 'app_albums')]
    public function index(AlbumRepository $albumRepository): Response
    {
        // Filtre uniquement les albums publiés
        $albums = $albumRepository->findBy(['Publier' => true]);

        return $this->render('album_photos/index.html.twig', [
            'albums' => $albums,
        ]);
    }

    // Affiche les photos d'un album spécifique, s'il est publié
    #[Route('/album/{id}', name: 'app_album_photos')]
    public function showPhotos(int $id, AlbumRepository $albumRepository): Response
    {
        // Récupère l'album par son ID
        $album = $albumRepository->find($id);

        // Vérifie si l'album existe et est publié
        if (!$album || !$album->isPublier()) {
            throw $this->createNotFoundException("L'album demandé n'est pas disponible.");
        }

        // Récupère toutes les photos liées à cet album
        $photos = $album->getPhotos();

        return $this->render('album_photos/show_photos.html.twig', [
            'album' => $album,
            'photos' => $photos,
        ]);
    }
}
