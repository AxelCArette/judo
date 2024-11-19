<?php

namespace App\Controller;

use App\Form\UtilisateurType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use App\Form\ChangePasswordType;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

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

            // Si un fichier est téléchargé, gérer la photo de profil
            if ($file) {
                // Si l'utilisateur a déjà une photo de profil, supprimer l'ancienne
                $oldPhoto = $user->getPhotosDeprofil();
                if ($oldPhoto) {
                    // Chemin du fichier existant
                    $oldFilePath = $this->getParameter('kernel.project_dir') . '/public/' . $oldPhoto;
                    
                    // Vérifier si le fichier existe et supprimer
                    if (file_exists($oldFilePath)) {
                        unlink($oldFilePath);
                    }
                }

                // Enregistrer la nouvelle photo
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

    #[Route('/utilisateur/changer-mot-de-passe', name: 'app_utilisateur_changer_mdp')]
    #[IsGranted("IS_AUTHENTICATED_FULLY")]
    public function changePassword(Request $request, UserPasswordHasherInterface $passwordHasher): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(ChangePasswordType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $currentPassword = $form->get('current_password')->getData();
            $newPassword = $form->get('new_password')->getData();
            $confirmPassword = $form->get('confirm_password')->getData();
            if (!$passwordHasher->isPasswordValid($user, $currentPassword)) {
                $this->addFlash('error', 'Mot de passe actuel incorrect.');
                return $this->redirectToRoute('app_utilisateur_changer_mdp');
            }
            if ($newPassword !== $confirmPassword) {
                $this->addFlash('error', 'Les nouveaux mots de passe ne correspondent pas.');
                return $this->redirectToRoute('app_utilisateur_changer_mdp');
            }
            $hashedPassword = $passwordHasher->hashPassword($user, $newPassword);
            $user->setMotdepasse($hashedPassword);
            $this->entityManager->flush();
            $this->addFlash('success', 'Mot de passe modifié avec succès.');
            return $this->redirectToRoute('app_utilisateur');
        }
        return $this->render('utilisateur/mdp.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
