<?php
namespace App\Controller;

use App\Entity\Stock;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controller de la page finance. Sur cette page seront affiché l'ensemble des dépenses de l'entreprise
 */
class FinanceController extends AbstractController {

    /**
     * La fonction calcule le coût total du stock pour pouvoir l'afficher
     * @return Response le twig correpondant à la page finance
     * @Route("/finance", name="finance")
     */
    public function index(): Response {
        $repository = $this->getDoctrine()->getRepository(Stock::class);
        $stocks = $repository->findAll();
        $total = 0;
        foreach ($stocks as $stock) {
            $total += $stock->getPrice() * $stock->getCount();
        }

        return $this->render('finance.html.twig', [
            'total' => $total,
        ]);
    }
}