<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RHController extends AbstractController {

    /**
     * @Route("/rh", name="rh")
     */
    public function index(): Response {

        return $this->render('rh.html.twig');
    }
}