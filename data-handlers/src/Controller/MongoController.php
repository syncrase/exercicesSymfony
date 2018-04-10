<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Serializer\Serializer;
//use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use App\Document\Evenement;
use Doctrine\ODM\MongoDB\Mapping\Annotations\Date;
use MongoDB\BSON\UTCDatetime;

class MongoController extends Controller {

    /**
     * @Route("/", name="home")
     */
    public function index() {


        $repository = $this->get('doctrine_mongodb')->getRepository(Evenement::class);
//        $this->deleteAll();
//        $evenement = 
//        $this->addingTest();
        $evenements = $repository->findAll();

        //https://symfony.com/doc/current/components/serializer.html
//        $normalizer = new ObjectNormalizer();
//        $encoder = new JsonEncoder();
//        $serializer = new Serializer([$normalizer], [$encoder]);
//        $evenementsJSON = $serializer->serialize($evenements, 'json');
        $visDataSet = $this->createVisDataSet($evenements);
        // Normalize in order to be used by vis.js
        // 1. Ids must be integers
        // 2. Date must be Date, not String
        // 3. Quotation marks of attribute must be removed

        return $this->render('chronologie/index.html.twig', [
//                    'evenement' => $evenement,
                    'evenements' => $evenements,
//                    'evenementsJSON' => $evenementsJSON,
                    'visDataSet' => $visDataSet
        ]);
    }

    /*     * ********************
     * PRIVATE FUNCTIONS
     * *********************** */

    /**
     * 
     * @return Evenement
     */
    private function addingTest() {
        $this->deleteAll();

        $evenement = new Evenement();
        $evenement->setName('Platon');
        $evenement->setStartDate('-428');
        $evenement->setEndDate('-348');

        $evenement2 = new Evenement();
        $evenement2->setName('1ère guerre mondiale');
        $evenement2->setStartDate('1914', '07', '28');
        $evenement2->setEndDate('1918', '11', '11');

        $evenement3 = new Evenement();
        $evenement3->setName('2nde guerre mondiale');
        $evenement3->setStartDate('1939', '09', '01');
        $evenement3->setEndDate('1945', '09', '02');

        $evenement4 = new Evenement();
        $evenement4->setName('déclaration Balfour');
        $evenement4->setStartDate('1917', '11', '2');


        $entityManager = $this->get('doctrine_mongodb')->getManager();
        $entityManager->persist($evenement);
        $entityManager->persist($evenement2);
        $entityManager->persist($evenement3);
        $entityManager->persist($evenement4);
        $entityManager->flush();
        return $evenement;
    }

    private function deleteAll() {

        $datamanager = $this->get('doctrine_mongodb')->getManager();
//        $repository = $this->get('doctrine_mongodb')->getRepository(Evenement::class);
        $evenements = $datamanager->getRepository(Evenement::class)->findAll();

        foreach ($evenements as $ev) {
            $datamanager->remove($ev);
        }
        $datamanager->flush();
//        return $evenement;
    }

    private function createVisDataSet($evenements) {
        // Parcours des éléments du JSON
        // Si je tombe sur l'id je remplace par un chiffre (garder la correspondance en mémoire??)
        // Si je tombe sur la date je la formatte en ajoutant new Date(-428, 0, 1) 
        // {id: 1, content: '1ère guerre mondiale', start: '1914-07-28', end: '1918-11-11'},
        $dataSet = '[';
        $id = 1;
        foreach ($evenements as $ev) {
//        for ($i = 0; $i < 1; $i++) {
            $dataSet .= '{';
            $dataSet .= 'id:' . $id++;
            $dataSet .= ', content:\'' . $ev->getName() . '\'';
            $dataSet .= ', start:' . $ev->getVisFriendlyStartDate();
            if ($ev->hasEnd()) {
                $dataSet .= ', end:' . $ev->getVisFriendlyEndDate();
            }
            $dataSet .= '},';
        }
        //Revome the last coma
        $dataSet = substr($dataSet, 0, -1);
        $dataSet .= ']';
        return $dataSet;
    }

}
