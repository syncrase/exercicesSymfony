<?php

// src/Controller/DefaultController.php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
//extends
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
//form      
use Symfony\Component\HttpFoundation\Request;
//use Symfony\Component\Form\Extension\Core\Type\TextType;
//use Symfony\Component\Form\Extension\Core\Type\DateType;
//use Symfony\Component\Form\Extension\Core\Type\SubmitType;
//use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Form\DefaultFormType;
use App\Entity\DefaultFormContent;

class DefaultController extends Controller {

    /**
     * @Route("/", name="homepage")
     */
    public function index() {

        $number = mt_rand(0, 100);

        return $this->redirectToRoute('formpage');

//        return $this->render('pages/index.html.twig', array(
//                    'number' => $number,
//        ));
    }

    /**
     * @Route("/{url}", name="remove_trailing_slash",
     *     requirements={"url" = ".*\/$"})
     */
    public function removeTrailingSlash(Request $request)
    {
        $pathInfo = $request->getPathInfo();
        $requestUri = $request->getRequestUri();

        $url = str_replace($pathInfo, rtrim($pathInfo, ' /'), $requestUri);

        // 308 (Permanent Redirect) is similar to 301 (Moved Permanently) except
        // that it does not allow changing the request method (e.g. from POST to GET)
        return $this->redirect($url, 308);
    }

    /**
     * @Route("/form", name="formpage")
     */
    public function form(Request $request) {

//        $defaults = array(
//            'dueDate' => new \DateTime('tomorrow'),
//        );

        $formContent = new DefaultFormContent();
        $form = $this->createForm(DefaultFormType::class, $formContent);
        // Remplie le formulaire ainsi créé avec le contenu de la requête
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
//            $data = $form->getData();
            // ... perform some action, such as saving the data to the database
            // Dans l'url, ce sera toujours "form" qui sera affiché
            return $this->render('pages/success.html.twig');
        }

        return $this->render('pages/form.html.twig', array(
                    'form' => $form->createView(),
        ));
    }

}
