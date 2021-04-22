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

/**
 * Controller de la page d'affichage du stock. Il contient également les méthodes pour ajouter et retirer des éléments
 */
class StockController extends AbstractController {

    /**
     * Initialise le formulaire pour la création de nouveau objet pour le stock. Lorsqu'il est valide, on vérifie si le nom et le prix renseignés existe déjà. Si c'est le cas,
     * l'objet existant est mis à jour en ajoutant la quantité saisie. Sinon un nouvel objet est créé et enregistré dans la base de données.
     * Un message de confirmation est alors affiché pour informer l'utilisateur. L'ensemble du stock est également récupéré pour pouvoir l'afficher.
     * @param Request requête les données du formulaire
     * @return Response le twig correspondant à la page de gestion des stocks
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
     * Fonction pour enlever une certaine quantité d'un objet. Si la quantité est égale au nombre maximum disponible, l'objet est supprimé de la base de données au lieu de mettre
     * la quantité à zéro
     * @param integer id de l'objet
     * @param integer quantité à soustraire
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