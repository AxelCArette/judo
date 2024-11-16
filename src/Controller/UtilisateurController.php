<?php

namespace App\Controller;

use App\Form\UtilisateurType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class UtilisateurController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/utilisateur', name: 'app_utilisateur')]
    #[IsGranted("IS_AUTHENTICATED_FULLY")]
    public function index(Request $request): Response
    {
        $user = $this->getUser();

        $form = $this->createForm(UtilisateurType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form->get('photo')->getData();
            $description = $form->get('description')->getData();
            $grade = $form->get('grade')->getData();

            // Gestion de l'upload de la photo de profil
            if ($file) {
                $newFilename = uniqid() . '.' . $file->guessExtension();
                $file->move(
                    $this->getParameter('kernel.project_dir') . '/public/asset/img/imagedeprofil',
                    $newFilename
                );
                $user->setPhotosDeprofil('asset/img/imagedeprofil/' . $newFilename);
            }

            $user->setDescription($description);
            $user->setGrade($grade);

            $this->entityManager->persist($user);
            $this->entityManager->flush();

            $this->addFlash('success', 'Profil mis à jour avec succès!');
        }

        return $this->render('utilisateur/index.html.twig', [
            'form' => $form->createView(),
            'nom' => $user->getNom(),
            'prenom' => $user->getPrenom(),
            'grade' => $user->getGrade(),
            'club' => $user->getClub(),
            'photoProfil' => $user->getPhotosDeprofil(),
            'description' => $user->getDescription(),
        ]);
    }
}
