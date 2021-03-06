<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\CrudUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Comment;
use App\Entity\Conference;

class DashboardController extends AbstractDashboardController
{
    /**
     * Index Function
     * 
     * @Route("/admin", name="admin")
     * 
     * @return \Symfony\Component\HttpFoundation\Response\ Response
     */
    public function index(): Response
    {
        // return parent::index();
        $routeBuilder = $this->get(CrudUrlGenerator::class)->build();
        $url = $routeBuilder->setController(
            ConferenceCrudController::class
        )->generateUrl();
        return $this->redirect($url);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Guestbook');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToRoute(
            'Back to the website',
            'fa fa-home',
            'homepage'
        );
        yield MenuItem::linkToCrud(
            'Conferences',
            'fas fa-map-marker-alt',
            Conference::class
        );

        yield MenuItem::linkToCrud(
            'Comments',
            'fas fa-comments',
            Comment::class
        );

    }
}
