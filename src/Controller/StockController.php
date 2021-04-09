<?php
namespace App\Controller;

use App\Entity\Stock;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StockController extends AbstractController {

    /**
     * @Route("/stock", name="stock")
     */
    public function index(Request $request): Response {
        $stock = new Stock();
        $form = $this->createFormBuilder($stock)
            ->add('item', TextType::class)
            ->add('price', NumberType::class)
            ->add('count', IntegerType::class)
            ->add('save', SubmitType::class)
            ->setAction($this->generateUrl('stock'))
            ->getForm();

        $form->handleRequest($request);

        $repository = $this->getDoctrine()->getRepository(Stock::class);
        $add = false;

        if ($form->isSubmitted() && $form->isValid()){
            $add = true;
            $em = $this->getDoctrine()->getManager();

            $stock = $form->getData();
            $result = $repository->findOneBy(array('item' => $stock->getItem(), 'price' => $stock->getPrice()));
            
            if ($result == null) {
                $em->persist($stock);
            } else {
                $result->setCount($stock->getCount() + $result->getCount());
            }
            $em->flush();
        }

        $stocks = $repository->findAll();

        return $this->render('stock.html.twig', [
            'stocks' => $stocks,
            'form' => $form->createView(),
            'add' => $add
        ]);
    }

    /**
     * @Route("/stock/{id}/{number}", name="stock_remove")
     */
    public function remove($id, $number) {
        $em = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getRepository(Stock::class);
        $stock = $repository->find($id);

        if ($stock != null) {
            if ($stock->getCount() == $number) {
                $em->remove($stock);
            } else {
                $stock->setCount($stock->getCount() - $number);
            }
            $em->flush();
        }

        return $this->redirectToRoute('stock');
    }
}