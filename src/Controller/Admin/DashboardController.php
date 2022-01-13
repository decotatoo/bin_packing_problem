<?php

namespace App\Controller\Admin;

use App\Entity\Master;
use App\Entity\Simulation;
use App\Entity\Unit;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return parent::index();
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Bin Packing Problem');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');

        yield MenuItem::linkToCrud('Master Box', 'fas fa-list', Master::class);
        yield MenuItem::linkToCrud('Unit', 'fas fa-list', Unit::class);
        yield MenuItem::linkToCrud('Simulation', 'fas fa-pallet', Simulation::class);
    }
}
