<?php

namespace App\Controller;

// Symfony basics
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
//use Symfony\Component\Validator\Validator\ValidatorInterface;
// Serializer
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
// Handled objects
use App\Document\TimelineItem;
use App\Adapters\VisTimeline;
use App\Adapters\VisTimelineItem;
use App\Adapters\AddTimelineItemFormType;
use App\Adapters\VisTimelineSerializationHelper;

//use Doctrine\ODM\MongoDB\Mapping\Annotations\Date;
//use MongoDB\BSON\UTCDatetime;

class MongoController extends Controller {

    /**
     * @Route("/", name="home")
     */
    public function index() {



//        $this->delete('5acfc36b15c8b92484000e02');


        $repository = $this->get('doctrine_mongodb')->getRepository(TimelineItem::class);
        $evenements = $repository->findAll();
//        $this->deleteAll();
        $this->addingTest();

        $visChronologie = new VisTimeline();
        $visChronologie->createTimeline($evenements);

        $form = $this->createForm(AddTimelineItemFormType::class);

        return $this->render('chronologie/index.html.twig', [
                    'evenements' => $evenements,
                    'visChronologie' => $visChronologie,
                    'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/addTimelineItem", name="addTimelineItem")
     */
    public function addItem(Request $request) {
        $form = $this->createForm(AddTimelineItemFormType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $evenement = new TimelineItem();
            $evenement->setContent($data->getContent());
            $start = $data->getSplitedStart();
            $evenement->setStart($start[0], $start[1], $start[2]);
            $end = $data->getSplitedEnd();
            if ($end !== null && count($end) === 3) {
                $evenement->setEnd($end[0], $end[1], $end[2]);
            }

            $entityManager = $this->get('doctrine_mongodb')->getManager();
            $entityManager->persist($evenement);
            $entityManager->flush();
        }
        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/updateMongo", name="updateMongo")
     */
    public function updateMongo(Request $request) {

        $dataset = $request->get('updatedDataSet');
        $idsAssociation = $request->get('idsAssociation');
        // Retourne un tableau associatif http://php.net/manual/fr/function.json-decode.php
        $idsAssociation = json_decode($idsAssociation, true);
        // see doc.: https://symfony.com/doc/current/components/serializer.html
        $encoders = array(new JsonEncoder());
        $normalizers = array(new ObjectNormalizer(), new ArrayDenormalizer());
        $serializer = new Serializer($normalizers, $encoders);
        $updatedDataSet = $serializer->deserialize($dataset, VisTimelineSerializationHelper::class . '[]', 'json');

        $mongoId = '';
        $visId = '';
        $report = '';
        $timelineItem;
        $visTimelineItem;
        foreach ($updatedDataSet as $visTimelineItem) {
            // Pour chacun des objets je regarde s'il existe une correspondance d'id
            $visId = (string) $visTimelineItem->getId();
            if (array_key_exists($visId, $idsAssociation)) {
                // L'objet existait de base dans la timeline => mise à jour
                // On met l'id originel
                $mongoId = $idsAssociation[$visId];
                $visTimelineItem->setId($mongoId);
                $timelineItem = new TimelineItem();
                $timelineItem->equalize($visTimelineItem);
//                $this->update($timelineItem);
                // Suppression de la table d'association (les objets non supprimés de la table d'association sont
                // les objets supprimés depuis la UI)
                unset($idsAssociation[$visId]);
                // $report .= 'u';
            } else {
                // L'évènement à été ajouté depuis la UI et doit être ajouté au document mongo
                // $report .= 'c';
            }
            // Si oui, j'update l'élément en question en question
            // Si non, je crée un nouvel évènement dans le document mongo
        }
        // Parcours de la table d'association pour supprimer du document mongo les évènement restants
        foreach ($idsAssociation as $idAssociation) {
            // $report .= 's';
        }


//                . '$idsAssociation : ' . var_dump($idsAssociation) . var_dump($dataset)
//                . '$timelineItems : ' . var_dump($updatedDataSet)
        //  . var_dump($timelineItem). var_dump($visTimelineItem). var_dump($updatedDataSet)
        return new Response(
                '<html><body>Report: ' . $report . '<br/>' . var_dump($dataset)
                . '</body></html>'
        );
    }

    /*     * ********************
     * PRIVATE FUNCTIONS
     * *********************** */

    /**
     * 
     * @return TimelineItem
     */
    private function addingTest() {
        $this->deleteAll();

        $evenement = new TimelineItem();
        $evenement->setContent('Platon');
        $evenement->setStart('-428');
        $evenement->setEnd('-348');

        $evenement2 = new TimelineItem();
        $evenement2->setContent('1ère guerre mondiale');
        $evenement2->setStart('1914', '07', '28');
        $evenement2->setEnd('1918', '11', '11');

        $evenement3 = new TimelineItem();
        $evenement3->setContent('2nde guerre mondiale');
        $evenement3->setStart('1939', '09', '01');
        $evenement3->setEnd('1945', '09', '02');

        $evenement4 = new TimelineItem();
        $evenement4->setContent('déclaration Balfour');
        $evenement4->setStart('1917', '11', '2');


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
        $evenements = $datamanager->getRepository(TimelineItem::class)->findAll();
        foreach ($evenements as $ev) {
            $datamanager->remove($ev);
        }
        $datamanager->flush();
    }

    private function delete(string $id) {
        $datamanager = $this->get('doctrine_mongodb')->getManager();
        $evenement = $datamanager->getRepository(TimelineItem::class)->find($id);
        if (!$evenement) {
            throw $this->createNotFoundException(
                    'Pas d\'évènement trouvé pour l\'id ' . $id
            );
        }
        $datamanager->remove($evenement);
        $datamanager->flush();
    }

}
