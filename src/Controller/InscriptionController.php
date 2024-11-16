<?php

namespace App\Controller;

use App\Entity\Membres;
use App\Form\InscriptionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class InscriptionController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher)
    {
        $this->entityManager = $entityManager;
        $this->passwordHasher = $passwordHasher;
    }

    #[Route('/inscription', name: 'app_inscription')]
    public function index(Request $request): Response
    {
        $membres = new Membres();
        $form = $this->createForm(InscriptionType::class, $membres);

        $form->handleRequest($request);

        // Vérification du honeypot
        if ($form->isSubmitted() && $form->isValid()) {
            $honeypot = $form->get('honeypot')->getData();

            if (!empty($honeypot)) {
                // Si le honeypot est rempli, rejeter la soumission
                throw new \Exception('Honeypot détecté, soumission invalide.');
            }

            // Vérifier si l'adresse e-mail est déjà utilisée
            $existingMember = $this->entityManager
                ->getRepository(Membres::class)
                ->findOneBy(['adressemail' => $membres->getAdressemail()]);

            if ($existingMember) {
                $this->addFlash('error', 'L\'adresse e-mail est déjà utilisée.');
                return $this->redirectToRoute('app_inscription');
            }

            // Hachage du mot de passe
            $hashedPassword = $this->passwordHasher->hashPassword($membres, $membres->getMotdepasse());
            $membres->setMotdepasse($hashedPassword);

            // Sauvegarde du membre
            $this->entityManager->persist($membres);
            $this->entityManager->flush();

            $this->addFlash('success', 'Inscription réussie.');
            return $this->redirectToRoute('app_login');
        }

        return $this->render('inscription/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
