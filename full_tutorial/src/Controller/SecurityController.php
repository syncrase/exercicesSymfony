<?php

namespace App\Controller;

use App\Form\UserType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Security;
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
    public function loginAction(AuthenticationUtils $authenticationUtils, Request $request)
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user. DOESN'T WORK ANYWHERE!!! Even when setting manually attribute in the request!!!
        // But I keep it because it initialize the variable to 'null' !!!
        $lastUsername = $authenticationUtils->getLastUsername();
        if ($request->getSession() instanceof SessionInterface) {
            $lastUsername = $request->getSession()->get(Security::LAST_USERNAME);
        }

        $form = $this->createForm(UserType::class
            , [
            '_username' => $lastUsername,
        ]
        );

        return $this->render(
            'security/login.html.twig',
            array(
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
