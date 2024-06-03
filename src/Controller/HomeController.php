<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    // Route pour afficher la page d'accueil
    #[Route('/home', name: 'app_home')]
    public function index(): Response
    {
        // Rendre la vue 'index' avec des données supplémentaires
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
