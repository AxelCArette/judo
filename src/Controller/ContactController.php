<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        // Vérifier si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {
            // Vérification du champ honeypot
            if ($form->get('honeypot')->getData()) {
                // Si le champ honeypot est rempli, c'est probablement un bot
                $this->addFlash('error', 'Soumission invalide détectée.');
                return $this->redirectToRoute('app_contact');
            }

            // Si tout est validé (pas de bot), persister le contact
            $entityManager->persist($contact);
            $entityManager->flush();

            // Ajouter un message de succès
            $this->addFlash('success', 'Votre message a été envoyé avec succès !');
            return $this->redirectToRoute('app_contact');
        }

        // Rendu du formulaire
        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
