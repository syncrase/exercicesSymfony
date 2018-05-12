<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * @param $value
     * @return User[]|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findAllCreatedOrderedByNewest()
    {
        $builder = $this->createQueryBuilder('u');
        return $this->addIsCreatedQueryBuilder(array($builder))
            ->orderBy('u.createdAt', 'DESC')
            ->getQuery()
            ->getResult()
            ;
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.createdAt IS NOT NULL') // Always the case
//            ->orderBy('u.createdAt', 'DESC')
//            ->getQuery()
//            ->getResult()
//            ;
    }

    /**
     * @param QueryBuilder[] $builder
     * @return QueryBuilder
     */
    private function addIsCreatedQueryBuilder($queryBuilderArray){
        return $this->getOrCreateQueryBuilder($queryBuilderArray)->andWhere('u.createdAt IS NOT NULL');
    }

    /**
     * Returns the passed queryBuilder or created a new one if no one is passed
     * @param QueryBuilder[] $queryBuilderArray
     * @return QueryBuilder
     */
    private function getOrCreateQueryBuilder($queryBuilderArray){

        if(count($queryBuilderArray) === 0){
            return $this->createQueryBuilder('u');
        }else if(count($queryBuilderArray) === 1){
            return $queryBuilderArray[0];
        }else{
            // throw Exception !!!
            // The array must contains 0 or 1 element. That's the trick that allow the optional parameter
        }
    }

    public function associationExample($term)
    {
        return $this->createQueryBuilder('user')
            ->andWhere('user.name LIKE :searchTerm
                OR user.fieldY LIKE :searchTerm
                OR comments.fieldX LIKE :searchTerm')
            ->leftJoin('user.comments', 'comments')
            ->setParameter('searchTerm', '%'.$term.'%')
            ->getQuery()
            ->execute();
    }
//    /**
//     * @return User[] Returns an array of User objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
