<?php
namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Controller de la page des ressources humaines. Cette dernière permet de visualiser les différents comptes utilisateurs, d'en créer ou d'en supprimer
 */
class RHController extends AbstractController {
    private $passwordEncoder;

    /**
     * Constructeur permettant d'initialiser l'encodeur de mot de passe
     * @param UserPasswordEncoderInterface Interface du service d'encodage de mot de passe
     */
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * Initialise le formulaire pour la création de nouveau compte utilisateur. Lorsqu'il est valide, encode le mot de passe saisi et enregistre l'entité dans la base de données.
     * Un message de confirmation est alors affiché pour informer l'utilisateur. L'ensemble des comptes est également récupéré pour pouvoir les afficher.
     * @param Request requête les données du formulaire
     * @return Response le twig correspondant à la page des ressources humaines
     * @Route("/rh", name="rh")
     */
    public function index(Request $request): Response {
        $user = new User();
        $form = $this->createFormBuilder($user)
            ->add('email', EmailType::class)
            ->add('password', PasswordType::class)
            ->add('save', SubmitType::class)
            ->setAction($this->generateUrl('rh'))
            ->getForm();

        $form->handleRequest($request);

        $add = false;

        if ($form->isSubmitted() && $form->isValid()){
            $add = true;
            $em = $this->getDoctrine()->getManager();

            $user = $form->getData();
            $user->setPassword($this->passwordEncoder->encodePassword($user, $user->getPassword()));
            $em->persist($user);
            $em->flush();
        }

        $repository = $this->getDoctrine()->getRepository(User::class);
        $users = $repository->findAll();

        return $this->render('rh.html.twig', [
            'users' => $users,
            'form' => $form->createView(),
            'add' => $add,
        ]);
    }

    /**
     * Fonction permettant de supprimer un compte utilisateur de la base de données
     * @param integer id du compte à supprimer 
     * @Route("/rh/{id}", name="rh_delete")
     */
    public function delete($id) {
        $em = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getRepository(User::class);
        $user = $repository->find($id);

        if ($user != null) {
            $em->remove($user);
            $em->flush();
        }

        return $this->redirectToRoute('rh');
    }
}