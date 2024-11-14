<?php

namespace App\Controller;

use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class PostController extends AbstractController
{
    #[Route('/utilisateur/posts', name: 'app_posts')]
    #[IsGranted('ROLE_USER')] 
    public function index(PostRepository $postRepository)
    {
        $posts = $postRepository->findPostsWithAuthor();

        return $this->render('post/index.html.twig', [
            'posts' => $posts,
        ]);
    }
}
