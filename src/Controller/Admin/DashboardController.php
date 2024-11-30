<?php

namespace App\Controller\Admin;

use App\Entity\Actualites;
use App\Entity\Album;
use App\Entity\Contact;
use App\Entity\Membres;
use App\Entity\Photos;
use App\Entity\Ressource;
use App\Entity\Sponsors;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DashboardController extends AbstractDashboardController
{

    #[Route('/judoclubadmin', name: 'admin')]
    public function index(): Response
    {
        return $this->render('admin/admin.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Judo Club Isbergues');
    }

    // Configuration du menu de navigation
    public function configureMenuItems(): iterable
    {
        // Menu principal avec les liens vers les CRUD des entités
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToUrl('Retour au site', 'fas fa-arrow-left', $this->generateUrl('app_accueil'));
        yield MenuItem ::Section ('Administration');
        yield MenuItem::linkToCrud('Formulaire de contact', 'fas fa-envelope', Contact::class);
        yield MenuItem::linkToCrud('Membres', 'fas fa-users', Membres::class);
        yield MenuItem::linkToCrud('Sponsors', 'fas fa-handshake', Sponsors::class);
        
        yield MenuItem ::Section ('Photos');
        yield MenuItem::linkToCrud('Album Photos', 'fas fa-images', Album::class);
        yield MenuItem::linkToCrud('Photos', 'fas fa-camera', Photos::class);
        yield MenuItem::linkToUrl('Voir les albums publiés', 'fas fa-arrow-left', $this->generateUrl('app_albums'));
        
        yield MenuItem ::Section ('Actualités');
        yield MenuItem::linkToCrud('Actualités', 'fas fa-newspaper', Actualites::class);
        yield MenuItem::linkToUrl('Voir les actualités', 'fas fa-arrow-left', $this->generateUrl('app_actualites'));
        
        yield MenuItem ::Section ('Ressources');
        yield MenuItem::linkToCrud('Ressource', 'fas fa-folder-open', Ressource::class);
    }
}
