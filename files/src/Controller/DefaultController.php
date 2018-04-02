<?php

// src/Controller/DefaultController.php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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

    /**
     * @Route("/file")
     */
    public function fileupload(Request $request) {
//Request $request
//        $defaults = array(
//            'dueDate' => new \DateTime('tomorrow'),
//        );
//        $formContent = new DefaultFormContent();
//        $form = $this->createForm(DefaultFormType::class, $formContent);
        // Remplie le formulaire ainsi créé avec le contenu de la requête
//        $form->handleRequest($request);
//        if ($form->isSubmitted() && $form->isValid()) {
//            $data = $form->getData();
        // ... perform some action, such as saving the data to the database
        // Dans l'url, ce sera toujours "form" qui sera affiché
//        return $this->render('pages/index.html.twig', array(
//                    'uploadstatus' => 'success',
//        ));

        if (isset($_FILES["fileToUpload"])) {
            $target_dir = "uploads/";
            // file_exists
            if (!is_dir('uploads')) {
                // name, rights, recursive flag
                mkdir('uploads', 0777, true);
            }

            $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            // Check if image file is a actual image or fake image
//        if (isset($_POST["submit"])) {
//            $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
//            if ($check !== false) {
//                echo "File is an image - " . $check["mime"] . ".";
//                $uploadOk = 1;
//            } else {
//                echo "File is not an image.";
//                $uploadOk = 0;
//            }
//        }
            $uploadmessage = "";
            // Check if file already exists
            if (file_exists($target_file)) {
                $uploadmessage = $uploadmessage . "Sorry, file already exists.\r";
                $uploadOk = 0;
            }

            // Check file size
            if ($_FILES["fileToUpload"]["size"] > 500000) {
                $uploadmessage = $uploadmessage . "Sorry, your file is too large.";
                $uploadOk = 0;
            }

            // Allow certain file formats
            // $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif"
            if ($imageFileType != "pdf") {
                // JPG, JPEG, PNG & GIF
                $uploadmessage = $uploadmessage . "Sorry, only PDF files are allowed.";
                $uploadOk = 0;
            }

            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                $uploadmessage = $uploadmessage . "Sorry, your file was not uploaded.";
                // if everything is ok, try to upload file
            } else {
                if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                    $uploadmessage = $uploadmessage . "The file " . basename($_FILES["fileToUpload"]["name"]) . " has been uploaded.";
                } else {
                    $uploadmessage = $uploadmessage . "Sorry, there was an error uploading your file.";
                }
            }
            return $this->render('pages/index.html.twig', array(
                        'uploadmessage' => $uploadmessage,
            ));
        } else {
            return $this->render('pages/index.html.twig');
        }
//        return $this->render('pages/index.html.twig');
//        }
    }

}
