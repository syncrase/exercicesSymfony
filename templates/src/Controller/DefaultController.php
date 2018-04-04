<?php

// src/Controller/DefaultController.php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
//extends
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
//form      
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller {

    /**
     * @Route("/", name="homepage")
     */
    public function index() {

        $number = mt_rand(0, 100);

//        return $this->redirectToRoute('formpage');

        return $this->render('pages/index.html.twig', array(
                    'number' => $number,
        ));
    }

}
