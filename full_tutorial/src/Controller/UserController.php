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
use App\Repository\UserRepository;
use App\Service\MarkdownHelper;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Cache\Adapter\AdapterInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
        $comments = [
            'I ate a normal rock once. It did NOT taste like bacon!',
            'Woohoo! I\'m going on an all-asteroid diet!',
            'I like bacon too! Buy some from my site! bakinsomebacon.com',
        ];

// No need to use these lines of code when we autowiring the entity. We just need to take care that the passed
// wildcard name is also an entity name of the entity
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
     * @Route("/news/{slug}/heart", name="user_toggle_heart", methods={"post"})
     */
    public function toggleUserHeart($slug){

        $this->logger->info('User heart');
//        return new JsonResponse(['hearts' => rand(5, 100)]);
        return $this->json(['hearts' => rand(5, 100)]);
    }


}
