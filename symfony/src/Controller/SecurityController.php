<?php

namespace App\Controller;

use App\Entity\Player;
use App\Form\PlayerType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Translation\TranslatorInterface;

class SecurityController extends Controller
{
    /**
     * @Route("/security", name="security")
     */
    public function index()
    {
        return $this->render('security/index.html.twig', [
            'controller_name' => 'SecurityController',
        ]);
    }

    /**
     * @Route("/login", name="login")
     * @Template()
     */
    public function login(Request $request, AuthenticationUtils $authenticationUtils)
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        $player = new Player();

        $form = $this->createFormBuilder($player)
            ->add('username', TextType::class, array(
                'label' => 'login.username',
                'attr' => array('value' => $lastUsername)

            ))
            ->add('password', PasswordType::class, array(
                'label' => 'login.password',

            ))
            ->add('save', SubmitType::class, array(
                'label' => 'login.connect'
            ))
            ->getForm();

        $form->handleRequest($request);

        /*if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->getRepository(Player::class)->findBy(array(
                'email' => $form->getNormData()['username'],
                'password' => $form->getNormData()['password']
            ));

            return $this->render('security/index.html.twig', array(
                'player' => $player,
                'last_username' => $lastUsername,
                'error' => $error,
                'form' => $form->createView(),
            ));
        }*/

        return array(
            'form' => $form->createView(),
            'last_username' => $lastUsername,
            'error'         => $error,
        );
    }

    /**
     * @Route("/subscribe", name="subscribe")
     * @Template()
     */
    public function subscribe(Request $request, TranslatorInterface $translator)
    {
        $player = new Player();

        $form = $this->createFormBuilder($player)
            ->add('username', TextType::class, array(
                'label' => $translator->trans('subscribe.username')
            ))
            ->add('password', RepeatedType::class, array(
                'type' => PasswordType::class,
                'first_options' => array('label' => $translator->trans('subscribe.password')),
                'second_options' => array('label' => $translator->trans('subscribe.confirm'))
            ))
            ->add('email', EmailType::class, array(
                'label' => $translator->trans('subscribe.mail')
            ))
            ->add('save', SubmitType::class, array(
                'label' => $translator->trans('subscribe.save')
            ))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $player = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($player);
            $entityManager->flush();

            return $this->redirectToRoute('login');
        }

        return array(
            'form' => $form->createView(),
        );
    }
}
