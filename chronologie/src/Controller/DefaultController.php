<?php

// src/Controller/DefaultController.php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller {
    
    /**
     * @Route("/", name="homepage")
     */
    public function index() {

        return $this->render('pages/index.html.twig');
    }
    
}
