<?php

namespace App\Controller;

use App\Classe\Mail;
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

        if ($form->isSubmitted() && $form->isValid()) {
            $honeypot = $form->get('honeypot')->getData();

            if (!empty($honeypot)) {
                throw new \Exception('Honeypot détecté, soumission invalide.');
            }

            $existingMember = $this->entityManager
                ->getRepository(Membres::class)
                ->findOneBy(['adressemail' => $membres->getAdressemail()]);
            if ($existingMember) {
                $this->addFlash('error', 'L\'adresse e-mail est déjà utilisée.');
                return $this->redirectToRoute('app_inscription');
            }

            $hashedPassword = $this->passwordHasher->hashPassword($membres, $membres->getMotdepasse());
            $membres->setMotdepasse($hashedPassword);
            $this->entityManager->persist($membres);
            $this->entityManager->flush();

            $mail = new Mail();
            $content="Bonjour ".$membres->getPrenom()."<br/> Bienvenue sur le judo club d'isbergues. ";
            $mail->send($membres->getAdressemail(), $membres->getPrenom(), 'Bienvenue sur le site du judo club d Isbergues',$content);

            $this->addFlash('success', 'Inscription réussie.');
            return $this->redirectToRoute('app_login');
        }

        return $this->render('inscription/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
