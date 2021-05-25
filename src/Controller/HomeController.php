<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controller de la page d'accueil, c'est le premier à être appelé lors de la connexion au site web. La page salue l'utilisateur et présente les différents onglets du site
 */
class HomeController extends AbstractController {

    /**
     * Si l'utilisateur n'est pas connecté, il est redirigé vers la page de login
     * @return Response le twig correspondant à la page d'accueil
     * @Route("/", name="home")
     */
    public function index(): Response {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }

        return $this->render('home.html.twig');
    }
}