<?php
namespace App\Controller;

use App\Entity\Stock;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FinanceController extends AbstractController {

    /**
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