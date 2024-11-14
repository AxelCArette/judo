<?php

namespace App\Controller\Admin;

use App\Entity\Actualites;
use App\Entity\Album;
use App\Entity\Contact;
use App\Entity\Membres;
use App\Entity\Photos;
use App\Entity\Sponsors;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DashboardController extends AbstractDashboardController
{
    // Route d'entrée du dashboard admin
    #[Route('/judoclubadmin', name: 'admin')]
    public function index(): Response
    {
        // Rendu de la vue principale du dashboard
        return $this->render('admin/admin.html.twig');
    }

    // Configuration du tableau de bord
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
        yield MenuItem ::Section ('Administration');
        yield MenuItem::linkToCrud('Formulaire de contact', 'fas fa-envelope', Contact::class);
        yield MenuItem::linkToCrud('Membres', 'fas fa-users', Membres::class);
        yield MenuItem::linkToCrud('Sponsors', 'fas fa-handshake', Sponsors::class);
        
        yield MenuItem ::Section ('Section Photos et actualités');
        yield MenuItem::linkToCrud('Album Photos', 'fas fa-images', Album::class);
        yield MenuItem::linkToCrud('Photos', 'fas fa-camera', Photos::class);
        yield MenuItem::linkToCrud('Actualités', 'fas fa-newspaper', Actualites::class);
    }
}
