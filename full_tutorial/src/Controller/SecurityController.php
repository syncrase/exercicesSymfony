<?php

namespace App\Controller;

use App\Form\UserType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

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
     * @Route("/login", name="security_login")
     */
    public function loginAction(AuthenticationUtils $authenticationUtils)
    {
//        , Request $request
//        dump($request);
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        $form = $this->createForm(UserType::class, [
            '_username' => $lastUsername,
        ]);

        if($form->isSubmitted()){
            dump($form);die;
        }
//dump($authenticationUtils);die;
        return $this->render(
            'security/login.html.twig',
            array(
                // last username entered by the user
                'form' => $form->createView(),
                'error' => $error,
            )
        );
//        return new Response(sprintf('hello'));
    }

    /**
     * @Route("/logout", name="security_logout")
     */
    public function logoutAction()
    {
        throw new \Exception('this should not be reached!');
}
}