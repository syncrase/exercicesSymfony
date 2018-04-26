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
use App\Core\VisJS\Timeline\VisTimeline;
use App\Core\VisJS\Timeline\Forms\TimelineControlPanelFormType;
use App\Core\VisJS\Timeline\VisTimelineSerializationHelper;

class MongoController extends Controller {

    /**
     * @Route("/", name="home")
     */
    public function index() {
//        $this->deleteAll();
//        $this->adding5Tests();
//        $this->addingJCTest();
//        $this->addingPlatonTest();
        $repository = $this->get('doctrine_mongodb')->getRepository(TimelineItem::class);
        $evenements = $repository->findAll();
//var_dump($evenements);
        $visChronologie = new VisTimeline();
        $visChronologie->initTimeline($evenements);


        $controlPanel = $this->createForm(TimelineControlPanelFormType::class);

        return $this->render('chronologie/index.html.twig', [
                    'evenements' => $evenements,
                    'visChronologie' => $visChronologie,
                    'controlPanel' => $controlPanel->createView(),
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
            $evenement->setStartYear($start[0]);
            $evenement->setStartMonth($start[1]);
            $evenement->setStartDay($start[2]);
            $end = $data->getSplitedEnd();
            // Comment ça count == 3 ? 
            // Ca veut dire que je ne peux pas rentrer juste une année et un mois ?!
            if ($end !== null && count($end) === 3) {
                $evenement->setEndYear($start[0]);
                $evenement->setEndMonth($start[1]);
                $evenement->setEndDay($start[2]);
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
        $metaTimeline = json_decode($request->get('metaTimeline'), true);
        $datamanager = $this->get('doctrine_mongodb')->getManager();

        $report = '';
        foreach ($metaTimeline as $metaItem) {
            if ($metaItem['action'] === 'no') {
                $report .= 'n';
                // Nothing to be done here!
            } elseif ($metaItem['action'] === 'update') {
                $report .= 'u';
                // Object has been updated front-side
                $evenement = $datamanager->getRepository(TimelineItem::class)->find($metaItem['mongoId']);
                if (!$evenement) {
                    throw $this->createNotFoundException(
                            'No TimelineItem found for id ' . $mongoId
                    );
                }
                $evenement->setContent($metaItem['content']);
                $evenement->setNotes($metaItem['notes']);
                $evenement->setStartYear($metaItem['start']['year']);
                $evenement->setStartMonth($metaItem['start']['month']);
                $evenement->setStartDay($metaItem['start']['day']);
                $evenement->setEndYear($metaItem['end']['year']);
                $evenement->setEndMonth($metaItem['end']['month']);
                $evenement->setEndDay($metaItem['end']['day']);
                $datamanager->flush();
            } elseif ($metaItem['action'] === 'create') {
                $report .= 'c';
                // Object has been created front-side
                $evenement = new TimelineItem();
                $evenement->setContent($metaItem['content']);
                $evenement->setNotes($metaItem['notes']);
                $evenement->setStartYear($metaItem['start']['year']);
                $evenement->setStartMonth($metaItem['start']['month']);
                $evenement->setStartDay($metaItem['start']['day']);
                $evenement->setEndYear($metaItem['end']['year']);
                $evenement->setEndMonth($metaItem['end']['month']);
                $evenement->setEndDay($metaItem['end']['day']);
                $datamanager->persist($evenement);
                $datamanager->flush();
            } elseif ($metaItem['action'] === 'delete') {
                $report .= 'd';
                // Object has been deleted front-side
                $evenement = $datamanager->getRepository(TimelineItem::class)->find($metaItem['mongoId']);
                if (!$evenement) {
                    throw $this->createNotFoundException(
                            'No TimelineItem found for id ' . $metaItem['mongoId']
                    );
                }
                $datamanager->remove($evenement);
                $datamanager->flush();
            }else{
                var_dump('Unkown action received from UI');
            }
        }

        return $this->redirectToRoute('home');
//        return new Response(
//                '<html><body>dumped report</body></html>' . var_dump($report)
//        );
    }

    /*     * *******************************************************************
     * ************************ PRIVATE FUNCTIONS ******************************
     * ********************************************************************** */

    /**
     * 
     * @return TimelineItem
     */
    private function adding5Tests() {
        $this->deleteAll();

        $evenement = new TimelineItem();
        $evenement->setContent('Platon');
        $evenement->setStartYear('-000428');
        $evenement->setEndYear('-000348');

        $evenement2 = new TimelineItem();
        $evenement2->setContent('1ère guerre mondiale');
        $evenement2->setStartYear('1914');
        $evenement2->setStartMonth('07');
        $evenement2->setStartDay('28');
        $evenement2->setEndYear('1918');
        $evenement2->setEndMonth('11');
        $evenement2->setEndDay('11');

        $evenement3 = new TimelineItem();
        $evenement3->setContent('2nde guerre mondiale');
        $evenement3->setStartYear('1939');
        $evenement3->setStartMonth('09');
        $evenement3->setStartDay('01');
        $evenement3->setEndYear('1945');
        $evenement3->setEndMonth('09');
        $evenement3->setEndDay('02');

        $evenement4 = new TimelineItem();
        $evenement4->setContent('déclaration Balfour');
        $evenement4->setStartYear('1917');
        $evenement4->setStartMonth('11');
        $evenement4->setStartDay('02');

        $evenement5 = new TimelineItem();
        $evenement5->setContent('Jésus christ');
        $evenement5->setStartYear('0000');
        $evenement5->setEndYear('0033');
        $evenement5->setNotes('Ceci est une note');


        $entityManager = $this->get('doctrine_mongodb')->getManager();
        $entityManager->persist($evenement);
        $entityManager->persist($evenement2);
        $entityManager->persist($evenement3);
        $entityManager->persist($evenement4);
        $entityManager->persist($evenement5);
        $entityManager->flush();
        return $evenement;
    }

    /**
     * 
     * @return TimelineItem
     */
    private function addingJCTest() {
        $this->deleteAll();

        $evenement5 = new TimelineItem();
        $evenement5->setContent('Jésus christ');
        $evenement5->setStartYear('0000');
        $evenement5->setEndYear('0033');


        $entityManager = $this->get('doctrine_mongodb')->getManager();
        $entityManager->persist($evenement5);
        $entityManager->flush();
        return $evenement5;
    }

    /**
     * 
     * @return TimelineItem
     */
    private function addingPlatonTest() {
        $this->deleteAll();

        $evenement = new TimelineItem();
        $evenement->setContent('Platon');
        $evenement->setStartYear('-000428');
        $evenement->setEndYear('-000348');


        $entityManager = $this->get('doctrine_mongodb')->getManager();
        $entityManager->persist($evenement);
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
