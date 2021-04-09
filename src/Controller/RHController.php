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

class RHController extends AbstractController {
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
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