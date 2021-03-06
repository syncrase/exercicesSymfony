<?php
/**
 * Created by PhpStorm.
 * User: Pierre
 * Date: 04/05/2018
 * Time: 21:46
 */

namespace App\Controller;


//use Michelf\MarkdownInterface;
use App\Entity\User;
use App\Form\UserRegistrationType;
use App\Repository\UserRepository;
use App\Security\LoginFormAuthenticator;
use App\Service\MarkdownHelper;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Cache\Adapter\AdapterInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;

class UserController extends AbstractController
{
    private $logger;
    private $markdownHelper;

    function __construct(LoggerInterface $logger, MarkdownHelper $markdownHelper, $isDebug)
    {
        $this->logger = $logger;
        $this->markdownHelper = $markdownHelper;
    }

    /**
     * @Route("/", name="app_homepage")
     */
    public function homepage(UserRepository $repository){

//        $repository = $em->getRepository(User::class); // Prefered way => autowiring the repository
//        $users = $repository->findAll();
        // Nothing in the where close => we fetch all
//        $users = $repository->findBy([], ['createdAt' => 'DESC']);
        $users = $repository->findAllCreatedOrderedByNewest();
        return $this->render('user/homepage.html.twig', [
            'users' => $users,
        ]);
    }

    /**
     * @Route("/user/{id}", name="show_user")
     */
    public function showUser(User $user){
        $comments = $user->getComments();

// No need to use these lines of code when we autowiring the entity. We just need to take care that the passed
// wildcard name is also an field name of the entity
//        $repository = $em->getRepository(User::class);
//        $user = $repository->findOneBy(['id' => $id]);
//        if (!$user) {
//            throw $this->createNotFoundException(sprintf('No user for id "%s"', $user));
//        }


        return $this->render('user/show.html.twig', [
            'user' => $user,
            'comments' => $comments,
        ]);
//        return new Response(sprintf('hello %s', $id));
    }

    /**
     * @Route("/news/{id}/heart", name="user_toggle_heart", methods={"post"})
     */
    public function toggleUserHeart(User $user, EntityManagerInterface $entityManager){

//        $this->logger->info('User heart: '.$user->getHeartCount());
        $user->incrementHeartCount();
        $entityManager->flush();

        return $this->json(['hearts' => $user->getHeartCount()]);
    }

    /**
     * @Route("/register", name="user_register")
     */
    public function registerAction(Request $request, UserPasswordEncoderInterface $passwordEncoder, GuardAuthenticatorHandler $guardAuthenticatorHandler, LoginFormAuthenticator $loginFormAuthenticator)
    {
        $form = $this->createForm(UserRegistrationType::class);
        $form->handleRequest($request);
//        dump($form);die;
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var User $user */
            $user = $form->getData();
//            dump($user);die;
            $user->setCreatedAt(new \DateTime())
                ->setPassword($passwordEncoder->encodePassword($user,$user->getPassword()));
            $user->getRoles();

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            $this->addFlash('success', 'Welcome '.$user->getEmail());
//            return $this->redirectToRoute('app_homepage');
            return $guardAuthenticatorHandler->authenticateUserAndHandleSuccess($user, $request, $loginFormAuthenticator, 'main');
        }

        return $this->render('user/register.html.twig', [
            'form' => $form->createView()
        ]);

    }

}
