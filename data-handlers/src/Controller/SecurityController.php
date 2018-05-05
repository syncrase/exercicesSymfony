<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Core\User\Forms\SignInFormType;
use App\Core\User\Forms\SignUpFormType;
use App\Document\User;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Description of UserController
 *
 * @author Pierre
 */
class SecurityController extends Controller {

    /**
     * @Route("/", name="home")
     */
    public function home() {


        $signInForm = $this->createForm(SignInFormType::class);
        $signUpForm = $this->createForm(SignUpFormType::class);


        return $this->render('common/login.html.twig', [
                    'signIn' => $signInForm->createView(),
                    'signUp' => $signUpForm->createView()]);
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logout() {
        
    }

    /**
     * Default route when user wants to access unauthorized content
     * @ Route("/login", name="login")
     */
//    public function login() {
//
//        $signInForm = $this->createForm(SignInFormType::class);
//        $signUpForm = $this->createForm(SignUpFormType::class);
//
//
//        return $this->render('common/login.html.twig', [
//                    'signIn' => $signInForm->createView(),
//                    'signUp' => $signUpForm->createView()]);
//    }

    /**
     * @Route("/login", name="login")
     */
    public function login(Request $request) {
        // get the login error if there is one , AuthenticationUtils $authenticationUtils
//        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
//        $lastUsername = $authenticationUtils->getLastUsername();


        $form = $this->createForm(SignInFormType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
//            $data = $form->getData();
//            $datamanager = $this->get('doctrine_mongodb')->getManager();
//            $user = new User();
//            $user->setUsername($data->getUsername());
// , UserPasswordEncoderInterface $encoder
//            $encoded = $encoder->encodePassword($user, $data->getPassword());
//            $user->setPassword($data->getPassword());


//            $userReturned = $this->get('doctrine_mongodb')->getRepository(User::class)->findByCredentials($user);
//            $this->get('doctrine_mongodb')->getRepository(User::class)->findOneBy([
//                'username' => $user->getUsername(),
//                'password' => $user->getPassword(),
//            ]);

//            if ($userReturned->getId() !== null) {
//                return new Response('<html><body>Je t\'ai retrouvé dans mongo, c\'est good</body></html>' . var_dump($userReturned));
                return $this->redirectToRoute('timeline');
//                return $this->get('security.authentication.guard_handler')
//                                ->authenticateUserAndHandleSuccess(
//                                        $user, $request, $this->get('app.security.login_form_authenticator'), 'main'
//                );
//            } else {
//                return new Response('<html><body>Impossible de te retrouver! 111 </body></html>' . var_dump($user));
//  . var_dump($user2)
//                $signUpForm = $this->createForm(SignUpFormType::class);
//                return $this->render('common/login.html.twig', array(
////                            'signIn' => $form->createView(),
//                            'signUp' => $signUpForm->createView(),
//                            'last_username' => $lastUsername,
//                            'error' => $error,
//                ));
//            }
        }
//        submited: ' . $form->isSubmitted() . '; valid: ' . $form->isValid() . '
//        . var_dump($form)
//         submited: ' . var_dump($form) . '
        return new Response('<html><body>Impossible de te retrouver! 222;</body></html>');
//        return $this->redirectToRoute('home');
        // retourner le formulaire pour avoir les informations de validation
//        return $this->render('default/new.html.twig', array(
//                    'form' => $form->createView(),
//        ));
    }

    /**
     * @Route("/signup", name="signup")
     */
    public function signUp(Request $request) {

        $form = $this->createForm(SignUpFormType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $datamanager = $this->get('doctrine_mongodb')->getManager();

            $user = new User();
            $user->setUsername($data->getUsername());
            $user->setPassword($data->getPassword());
            $user->setEmail($data->getEmail());
            $datamanager->persist($user);
            $datamanager->flush();
            return $this->redirectToRoute('timeline');
        }


        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/admin", name="admin")
     */
    public function admin() {


        return new Response('<html><body>Admin page!</body></html>');
    }

}
