<?php
/**
 * Created by PhpStorm.
 * User: Pierre
 * Date: 04/05/2018
 * Time: 21:46
 */

namespace App\Controller;


//use Michelf\MarkdownInterface;
use App\Service\MarkdownHelper;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Cache\Adapter\AdapterInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    private $logger;
    private $cache;
    private $markdownHelper;

    function __construct(LoggerInterface $logger, AdapterInterface $cache, MarkdownHelper $markdownHelper)
    {
        $this->logger = $logger;
        $this->cache = $cache;
        $this->markdownHelper = $markdownHelper;
    }

    /**
     * @Route("/", name="app_homepage")
     */
    public function homepage(){

        return $this->render('user/homepage.html.twig');
    }

    /**
     * @Route("/user/{showUserParam1}", name="show_user")
     */
    public function showUser($showUserParam1){
//        return new Response(sprintf('hello %s', $id));
        $comments = [
            'I ate a normal rock once. It did NOT taste like bacon!',
            'Woohoo! I\'m going on an all-asteroid diet!',
            'I like bacon too! Buy some from my site! bakinsomebacon.com',
        ];

        $userContent = <<<EOF
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
EOF;

        // Create a cache object in memory that helps to fetch and cache
//        $item = $this->cache->getItem('markdown_'.md5($userContent));
//        if(!$item->isHit()){
//            $item->set($markdown->transform($userContent));
//            $this->cache->save($item);
//        }
//        $userContent = $item->get();
//        $userContent = $markdown->transform($userContent);

        $userContent = $this->markdownHelper->parse($userContent);

//        dump($this->cache);die;
//        dump($id, $this);
        return $this->render('user/show.html.twig', [
            'title' => ucwords(str_replace('-', ' ', $showUserParam1)),
            'slug' => $showUserParam1,
            'userContent' => $userContent,
            'comments' => $comments,
        ]);
    }

    /**
     * @Route("/news/{slug}/heart", name="user_toggle_heart", methods={"post"})
     */
    public function toggleUserHeart($slug){

        $this->logger->info('hi there');
//        return new JsonResponse(['hearts' => rand(5, 100)]);
        return $this->json(['hearts' => rand(5, 100)]);
    }
}
