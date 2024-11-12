<?php

namespace App\Controller\Admin;

use App\Entity\Album;
use App\Entity\Membres;
use App\Entity\Gradecouleur;
use App\Entity\Photos;
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
            ->setTitle('Judo club isbergues');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Membres', 'fas fa-list', Membres::class);
        yield MenuItem::linkToCrud('Sponsors', 'fas fa-list', Sponsors::class);
        yield MenuItem::linkToCrud('Album Photos', 'fas fa-list',Album::class);
        yield MenuItem::linkToCrud('Photos', 'fas fa-list', Photos::class);
    }
}
