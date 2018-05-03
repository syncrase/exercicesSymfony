<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use App\Core\User\Forms\SignInFormType;
use App\Core\User\Forms\SignUpFormType;

/**
 * Description of UserController
 *
 * @author Pierre
 */
class UserController extends Controller {

    /**
     * @Route("/", name="home")
     */
    public function index() {

        $signInForm = $this->createForm(SignInFormType::class);
        $signUpForm = $this->createForm(SignUpFormType::class);


        return $this->render('common/login.html.twig', [
                    'signIn' => $signInForm->createView(),
                    'signUp' => $signUpForm->createView()]);
    }
    
    /**
     * @Route("/login", name="login")
     */
    public function login(Request $request) {

        $form = $this->createForm(SignInFormType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            return $this->redirectToRoute('timeline');
        }


        return $this->redirectToRoute('home');
    }
}
