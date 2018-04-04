<?php

namespace App\Repository;

use App\Entity\Concept;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Concept|null find($id, $lockMode = null, $lockVersion = null)
 * @method Concept|null findOneBy(array $criteria, array $orderBy = null)
 * @method Concept[]    findAll()
 * @method Concept[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConceptRepository extends ServiceEntityRepository {

    public function __construct(RegistryInterface $registry) {
        parent::__construct($registry, Concept::class);
    }

//    /**
//     * @return Concept[] Returns an array of Concept objects
//     */
    /*
      public function findByExampleField($value)
      {
      return $this->createQueryBuilder('c')
      ->andWhere('c.exampleField = :val')
      ->setParameter('val', $value)
      ->orderBy('c.id', 'ASC')
      ->setMaxResults(10)
      ->getQuery()
      ->getResult()
      ;
      }
     */

    /*
      public function findOneBySomeField($value): ?Concept
      {
      return $this->createQueryBuilder('c')
      ->andWhere('c.exampleField = :val')
      ->setParameter('val', $value)
      ->getQuery()
      ->getOneOrNullResult()
      ;
      }
     */

    /**
     * @ param $price
     * @ return Product[]
     */
//    public function findAllGreaterThanPrice($price): array
//    {
//        // automatically knows to select Products
//        // the "p" is an alias you'll use in the rest of the query
//        $qb = $this->createQueryBuilder('p')
//            ->andWhere('p.price > :price')
//            ->setParameter('price', $price)
//            ->orderBy('p.price', 'ASC')
//            ->getQuery();
//
//        return $qb->execute();
//
//        // to get just one result:
//        // $product = $qb->setMaxResults(1)->getOneOrNullResult();
//    }

    public function anotherWayToRequest($price): array {
        // With DQL (Doctrine Query Language)
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
                        'SELECT p
        FROM App\Entity\Product p
        WHERE p.price > :price
        ORDER BY p.price ASC'
                )->setParameter('price', 10);

        // returns an array of Product objects
        return $query->execute();

        // Or directly SQL
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
        SELECT * FROM product p
        WHERE p.price > :price
        ORDER BY p.price ASC
        ';
        $stmt = $conn->prepare($sql);
        $stmt->execute(['price' => 10]);

        // returns an array of arrays (i.e. a raw data set!!! Not an object)
        return $stmt->fetchAll();
    }

}
