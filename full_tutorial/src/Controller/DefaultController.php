<?php
/**
 * Created by PhpStorm.
 * User: Pierre
 * Date: 04/05/2018
 * Time: 21:46
 */

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{

    /**
     * @Route("/")
     */
    public function homepage(){

        return new Response('hello');
    }

    /**
     * @Route("/user/{id}", name="showuser")
     */
    public function showUser($id){
//        return new Response(sprintf('hello %s', $id));
        $comments = [
            'I ate a normal rock once. It did NOT taste like bacon!',
            'Woohoo! I\'m going on an all-asteroid diet!',
            'I like bacon too! Buy some from my site! bakinsomebacon.com',
        ];

//        dump($id, $this);
        return $this->render('user/show.html.twig', [
            'title' => ucwords(str_replace('-', ' ', $id)),
            'comments' => $comments,
        ]);
    }

}
