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
        $visFriendlyIds = json_decode($request->get('visFriendlyIds'), true);
        $visFriendlyDates = json_decode($request->get('visFriendlyDates'), true);
        $encoders = array(new JsonEncoder());
        $normalizers = array(new ObjectNormalizer(), new ArrayDenormalizer());
        $serializer = new Serializer($normalizers, $encoders);
        $deserializedVisDataset = $serializer->deserialize(
                $request->get('updatedDataSet'), VisTimelineSerializationHelper::class . '[]', 'json'
        );
        $datamanager = $this->get('doctrine_mongodb')->getManager();

        foreach ($deserializedVisDataset as $deserializedVisTimelineItem) {

            $visId = (string) $deserializedVisTimelineItem->getId();
            // Initialize a timeline from the serialization helper
            $deserializedVisTimelineItem->initTimelineItem();
            // Remove the visJSFriendly adaptation
            $deserializedVisTimelineItem->unadapt($visFriendlyDates[$visId]);
            $timelineItem = $deserializedVisTimelineItem->getTimelineItem();

            if (array_key_exists($visId, $visFriendlyIds)) {
                $mongoId = $visFriendlyIds[$visId];
                $storedItem = $datamanager->getRepository(TimelineItem::class)->find($mongoId);
                if (!$storedItem) {
                    throw $this->createNotFoundException(
                            'No TimelineItem found for id ' . $mongoId
                    );
                }
                
                // Si les deux objets sont différents => update
                if (!$storedItem->equals($timelineItem)) {
                    $storedItem->updateFields($timelineItem);
                    $datamanager->flush();
                    //var_dump($storedItem);
                } else {
                    // Do not update the item because the current item wasn't be modified
                }
                // Suppression de la table d'association (les objets non supprimés de la table d'association sont
                // les objets supprimés depuis la UI)
                unset($visFriendlyIds[$visId]);
            } else {
                // L'évènement à été ajouté depuis la UI et doit être ajouté au document mongo
                $datamanager->persist($timelineItem);
                $datamanager->flush();
            }
        }
        // Parcours de la table d'association pour supprimer du document mongo les évènements restants
        // Les évènements qui restent dans la table d'association sont ceux qui ne sont pas dans la liste
        // d'évènements reçue => ils ont donc été supprimés par l'utilisateur.
        foreach ($visFriendlyIds as $visFriendlyId) {
            // $visFriendlyId: this is the value = mongo id
            $storedItem = $datamanager->getRepository(TimelineItem::class)->find($visFriendlyId);
            if (!$storedItem) {
                throw $this->createNotFoundException(
                        'No TimelineItem found for id ' . $visFriendlyId
                );
            }
            $datamanager->remove($storedItem);
            $datamanager->flush();
        }

        return $this->redirectToRoute('home');
//        return new Response(
//            '<html><body>ok</body></html>'
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
