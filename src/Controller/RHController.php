<?php
namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controller de la page des ressources humaines. Cette dernière permet de visualiser les différents comptes utilisateurs, d'en créer ou d'en supprimer
 */
class RHController extends AbstractController {

    /**
     * Initialise le formulaire pour la création de nouveau compte utilisateur. Lorsqu'il est valide, encode le mot de passe saisi et enregistre l'entité dans la base de données.
     * Un message de confirmation est alors affiché pour informer l'utilisateur. L'ensemble des comptes est également récupéré pour pouvoir les afficher.
     * @return Response le twig correspondant à la page des ressources humaines
     * @Route("/rh", name="rh")
     */
    public function index(): Response {
        $repository = $this->getDoctrine()->getRepository(User::class);
        $users = $repository->findAll();

        return $this->render('rh.html.twig', [
            'users' => $users,
        ]);
    }
}