<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
//use Symfony\Component\Validator\Validator\ValidatorInterface;
//use Symfony\Component\Serializer\Serializer;
//use Symfony\Component\Serializer\Encoder\XmlEncoder;
//use Symfony\Component\Serializer\Encoder\JsonEncoder;
//use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use App\Document\TimelineItem;
use App\Adapters\VisTimeline;
use App\Adapters\AddTimelineItemFormType;

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
//        $this->addingTest();

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
