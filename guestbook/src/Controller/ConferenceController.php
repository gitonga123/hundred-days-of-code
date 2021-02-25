<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ConferenceController extends AbstractController
{
    /**
     * Index Page
     *
     * @Route("/", name="homepage")
     *
     * @return mixed
     */
    public function index(): Response
    {
        return $this->render(
            'conference/index.html.twig',
            [
                'controller_name' => 'ConferenceController',
            ]
        );
    }
}