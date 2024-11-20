<?php

namespace App\Controller;

use App\Repository\AlbumRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AlbumPhotosController extends AbstractController
{
    #[Route('/albums', name: 'app_albums')]
    public function index(AlbumRepository $albumRepository): Response
    {
        $albums = $albumRepository->findBy(['Publier' => true]);
        return $this->render('album_photos/index.html.twig', [
            'albums' => $albums,
        ]);
    }
    #[Route('/album/{id}', name: 'app_album_photos')]
    public function showPhotos(int $id, AlbumRepository $albumRepository): Response
    {
        $album = $albumRepository->find($id);
        if (!$album || !$album->isPublier()) {
            throw $this->createNotFoundException("L'album demandé n'est pas disponible.");
        }
        $photos = $album->getPhotos();
        return $this->render('album_photos/show_photos.html.twig', [
            'album' => $album,
            'photos' => $photos,
        ]);
    }
}
