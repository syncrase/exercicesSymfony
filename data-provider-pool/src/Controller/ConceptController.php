<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Concept;

class ConceptController extends Controller {

    /**
     * @Route("/concept", name="concept")
     */
    public function index() {

        // you can fetch the EntityManager via $this->getDoctrine()
        // or you can add an argument to your action: index(EntityManagerInterface $entityManager)
        $entityManager = $this->getDoctrine()->getManager();

        $concept = new Concept();
        $concept->setName('Plante');
        $concept->setDescription('Un truc qui pousse');

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($concept);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        // return new Response('Saved new product with id '.$concept->getId());


        return $this->render('concept/index.html.twig', [
                    'controller_name' => 'ConceptController',
                    'conceptId' => $concept->getId(),
        ]);
    }

    /**
     * @Route("/concept/{id}", name="concept_show")
     */
    public function showAction($id) {
        $repository = $this->getDoctrine()->getRepository(Concept::class);
        $concept = $repository->find($id);
        // look for a single Product by name
        //$product = $repository->findOneBy(['name' => 'Keyboard']);
        //
        // or find by name and price
        //$product = $repository->findOneBy([
        //    'name' => 'Keyboard',
        //    'price' => 19.99,
        //]);
        // look for multiple Product objects matching the name, ordered by price
        //$products = $repository->findBy(
        //    ['name' => 'Keyboard'],
        //    ['price' => 'ASC']
        //);
        // look for *all* Product objects
        //$products = $repository->findAll();


        if (!$concept) {
            throw $this->createNotFoundException(
                    'No concept found for id ' . $id
            );
        }

        return new Response('Check out this great concept: ' . $concept->getName());

        // or render a template
        // in the template, print things with {{ concept.name }}
        // return $this->render('concept/show.html.twig', ['concept' => $concept]);
    }

    /**
     * @Route("/concept/edit/{id}")
     */
    public function updateAction($id) {
        $entityManager = $this->getDoctrine()->getManager();
        $concept = $entityManager->getRepository(Concept::class)->find($id);

        if (!$concept) {
            throw $this->createNotFoundException(
                    'No concept found for id ' . $id
            );
        }

        $concept->setName('New concept name!');
        $entityManager->flush();

        return $this->redirectToRoute('concept_show', [
                    'id' => $concept->getId()
        ]);
    }

    /**
     * @Route("/concept/delete/{id}")
     */
    public function deleteAction($id) {
        $entityManager = $this->getDoctrine()->getManager();
        $concept = $entityManager->getRepository(Concept::class)->find($id);

        if (!$concept) {
            throw $this->createNotFoundException(
                    'No concept found for id ' . $id
            );
        }

        $entityManager->remove($concept);
        $entityManager->flush();

        return $this->redirectToRoute('concept');
    }
}
