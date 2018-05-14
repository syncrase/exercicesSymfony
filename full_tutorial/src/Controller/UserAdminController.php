<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class UserAdminController extends Controller
{
    /**
     * Annotation may be set on the controller
     * @Security("has_role('ROLE_ADMIN')")
     * @Security("is_granted('ROLE_ADMIN')")
     * @Route("/user/admin", name="user_admin")
     */
    public function index(AuthorizationCheckerInterface $authChecker)
    {
        // The second parameter is used to specify on what object the role is tested.
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Unable to access this page!');

        if (false === $authChecker->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException('Unable to access this page!');
        }

        return $this->render('user_admin/index.html.twig', [
            'controller_name' => 'UserAdminController',
        ]);
    }

    /**
     * @Route("/admin/user/new")
     */
    public function new(EntityManagerInterface $em, UserPasswordEncoderInterface $passwordEncoder)
    {

        $nb = '1';
        $user = new User();
        $user->setName('User name '.$nb)
            ->setEmail('email'.$nb.'@email.email')
            ->setPassword($passwordEncoder->encodePassword($user,'password'))
            ->setDescription(<<<EOF
Spicy **jalapeno bacon** ipsum dolor amet veniam shank in dolore. Ham hock nisi landjaeger cow,
lorem proident [beef ribs](https://baconipsum.com/) aute enim veniam ut cillum pork chuck picanha. Dolore reprehenderit
labore minim pork belly spare ribs cupim short loin in. Elit exercitation eiusmod dolore cow
turkey shank eu pork belly meatball non cupim.
Laboris beef ribs fatback fugiat eiusmod jowl kielbasa alcatra dolore velit ea ball tip. Pariatur
laboris sunt venison, et laborum dolore minim non meatball. Shankle eu flank aliqua shoulder,
capicola biltong frankfurter boudin cupim officia. Exercitation fugiat consectetur ham. Adipisicing
picanha shank et filet mignon pork belly ut ullamco. Irure velit turducken ground round doner incididunt
occaecat lorem meatball prosciutto quis strip steak.
Meatball adipisicing ribeye bacon strip steak eu. Consectetur ham hock pork hamburger enim strip steak
mollit quis officia meatloaf tri-tip swine. Cow ut reprehenderit, buffalo incididunt in filet mignon
strip steak pork belly aliquip capicola officia. Labore deserunt esse chicken lorem shoulder tail consectetur
cow est ribeye adipisicing. Pig hamburger pork belly enim. Do porchetta minim capicola irure pancetta chuck
fugiat.
EOF
            )
            ->setImageFilename('asteroid.jpeg')
            ->setCreatedAt(new \DateTime());
        $em->persist($user);


        $comment = new Comment();
        $comment->setUser($user)
            ->setComment('I ate a normal rock once. It did NOT taste like bacon! ('.$nb.')')
            ->setCreatedAt(new \DateTime());
        $em->persist($comment);
        $comment2 = new Comment();
        $comment2->setUser($user)
            ->setComment('Woohoo! I\'m going on an all-asteroid diet! ('.$nb.')')
            ->setCreatedAt(new \DateTime());
        $em->persist($comment2);
        $comment3 = new Comment();
        $comment3->setUser($user)
            ->setComment('I like bacon too! Buy some from my site! bakinsomebacon.com ('.$nb.')')
            ->setCreatedAt(new \DateTime());
        $em->persist($comment3);


        $em->flush();

        return new Response(sprintf(
            'Hu mon dada! Nouvel utilisateur : %s',
            $user->getName()
        ));

    }
}
