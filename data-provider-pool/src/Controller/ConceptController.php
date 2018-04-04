<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\MySQL\Concept;
//use App\Entity\MongoDB\Concept2;
use App\Document\MongoDB\Concept2;

class ConceptController extends Controller {

    /**
     * @Route("/concept", name="concept")
     */
    public function index() {
        //**********************************************************************
//        // *****************   Persistance avec l'entity_manager mysql
        //**********************************************************************
//        // you can fetch the EntityManager via $this->getDoctrine()
//        // or you can add an argument to your action: index(EntityManagerInterface $entityManager)
//        $entityManager = $this->getDoctrine()->getManager('mysql');
//
//        $concept = new Concept();
//        $concept->setName('Plante');
//        $concept->setDescription('Un truc qui pousse');
//
//        // tell Doctrine you want to (eventually) save the Product (no queries yet)
//        $entityManager->persist($concept);
//
//        // actually executes the queries (i.e. the INSERT query)
//        $entityManager->flush();
        //**********************************************************************
        // *****************   Persistance avec l'entity_manager mongodb
        //**********************************************************************
//        $entityManager = $this->get('doctrine_mongodb')->getManager();
        $concept = new Concept2();
//        $concept->setName('Plante dans graph');
//        $concept->setDescription('Description dans graph');
//
//        $entityManager->persist($concept);
//        $entityManager->flush();

        return $this->render('concept/index.html.twig', [
                    'controller_name' => 'ConceptController',
                    'conceptId' => $concept->getId(),
        ]);
    }

    /**
     * @Route("/concept/{id}", name="concept_show")
     */
    public function showAction($id) {
//        $repository = $this->getDoctrine()->getRepository(Concept::class);
        // $repository = $this->get('doctrine_mongodb')->getRepository(Concept2::class);// -> fonctionne aussi!!
        $repository = $this->get('doctrine_mongodb')->getManager()->getRepository(Concept2::class);
        $concept = $repository->find($id);


        //**********************************************************************
        // ********************************* MongoDB ***************************
        //**********************************************************************
        // dynamic method names to find based on a column value
//        $concept = $repository->findOneById($id);
//        $concept = $repository->findOneByName('foo');
        // find a group of concepts based on an arbitrary column value
//        $concept = $repository->findByDescription('description');
//
//        if (!$concept) {
//            throw $this->createNotFoundException(
//                    'No concept found for id ' . $id
//            );
//        }
        //**********************************************************************
        // ********************************* Both ******************************
        //**********************************************************************
//        // ** look for a single Concept by name
//        $concept = $repository->findOneBy(['name' => 'Keyboard']);
//        // ** query for one concept matching be name and price
//        $concept = $repository->findOneBy(
//                array('name' => 'foo', 'price' => 19.99)
//        );
//        // or find by name and price
//        $concept = $repository->findOneBy([
//            'name' => 'Keyboard',
//            'price' => 19.99,
//        ]);
//        // ** look for multiple Concept objects matching the name, ordered by price
//        $concepts = $repository->findBy(
//                ['name' => 'Keyboard'], ['price' => 'ASC']
//        );
//        // query for all concepts matching the name, ordered by price
//        $concepts = $repository->findBy(
//                array('name' => 'foo'), array('price' => 'ASC')
//        );
//        // ** find *all* concepts
//        $concepts = $repository->findAll();

        return new Response('Check out this great concept: ' . $concept->getName());

        // or render a template
        // in the template, print things with {{ concept.name }}
        // return $this->render('concept/show.html.twig', ['concept' => $concept]);
    }

    /**
     * @Route("/concept/edit/{id}")
     */
    public function updateAction($id) {
//        // For MySQL
//        $datamanager = $this->getDoctrine()->getManager();// Get the default data manager
//        $concept = $entityManager->getRepository(Concept::class)->find($id);
        // For MongoDB
        $datamanager = $this->get('doctrine_mongodb')->getManager();
        $concept = $datamanager->getRepository(Concept2::class)->find($id);

        if (!$concept) {
            throw $this->createNotFoundException(
                    'No concept found for id ' . $id
            );
        }

        $concept->setName('New concept name!');
        $datamanager->flush();

        return $this->redirectToRoute('concept_show', [
                    'id' => $concept->getId()
        ]);
    }

    /**
     * @Route("/concept/delete/{id}")
     */
    public function deleteAction($id) {
//        // For MySQL
//        $datamanager = $this->getDoctrine()->getManager();// Get the default data manager
//        $concept = $entityManager->getRepository(Concept::class)->find($id);
        // For MongoDB
        $datamanager = $this->get('doctrine_mongodb')->getManager();
        $concept = $datamanager->getRepository(Concept2::class)->find($id);

        if (!$concept) {
            throw $this->createNotFoundException(
                    'No concept found for id ' . $id
            );
        }

        $datamanager->remove($concept);
        $datamanager->flush();

        return $this->redirectToRoute('concept');
    }

}
