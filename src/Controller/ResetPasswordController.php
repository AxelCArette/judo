<?php

namespace App\Controller;

use App\Classe\Mail;
use App\Entity\Membres;
use App\Entity\ResetPassword;
use App\Form\ResetPasswordType;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class ResetPasswordController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/mot-de-passe-oublie', name: 'app_reset_password')]
    public function index(Request $request): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('app_accueil');
        }
        if ($request->get('email')) {
            $user = $this->entityManager->getRepository(Membres::class)->findOneBy(['adressemail' => $request->get('email')]);
            if ($user) {
                $resetPassword = new ResetPassword();
                $resetPassword->setMembres($user);
                $resetPassword->setToken(uniqid());
                $resetPassword->setCreatedAt(new DateTime());
                $this->entityManager->persist($resetPassword);
                $this->entityManager->flush();

                $url = $this->generateUrl('app_update_password', [
                    'token' => $resetPassword->getToken()
                ], UrlGeneratorInterface::ABSOLUTE_URL);

                $content = "Bonjour " . $user->getPrenom() . ",<br/>Vous avez demandé une réinitialisation de mot de passe.<br/>";
                $content .= "Cliquez sur ce lien pour <a href='" . $url . "'>mettre à jour votre mot de passe</a>.";

                $mail = new Mail();
                $mail->send($user->getAdressemail(), $user->getPrenom() . ' ' . $user->getNom(), 'Réinitialisation de votre mot de passe', $content);

                $this->addFlash('notice', 'Un email vous a été envoyé pour réinitialiser votre mot de passe.');
            } else {
                $this->addFlash('danger', 'Cette adresse email est inconnue.');
            }
        }

        return $this->render('reset_password/index.html.twig');
    }

    #[Route('/modifier-mon-mot-de-passe/{token}', name: 'app_update_password')]
    public function update(string $token, Request $request, UserPasswordHasherInterface $encoder): Response
    {
        $resetPassword = $this->entityManager->getRepository(ResetPassword::class)->findOneBy(['token' => $token]);

        if (!$resetPassword) {
            return $this->redirectToRoute('app_reset_password');
        }

        $now = new DateTime();
        if ($now > $resetPassword->getCreatedAt()->modify('+ 1 hour')) {
            $this->addFlash('notice', 'Votre demande de mot de passe a expiré. Merci de la renouveler.');
            return $this->redirectToRoute('app_reset_password');
        }
        
        $form = $this->createForm(ResetPasswordType::class);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $new_pwd = $form->get('new_password')->getData();
        
            // Hachage du mot de passe
            $password = $encoder->hashPassword($resetPassword->getMembres(), $new_pwd);
        
            // Mise à jour du mot de passe de l'utilisateur
            $resetPassword->getMembres()->setMotdepasse($password); // Correction ici
        
            $this->entityManager->flush();
        
            $this->addFlash('notice', 'Votre mot de passe a bien été modifié.');
            return $this->redirectToRoute('app_login');
        }
        
        
        return $this->render('reset_password/update.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
