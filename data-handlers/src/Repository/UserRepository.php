<?php

namespace App\Repository;

use Doctrine\ODM\MongoDB\DocumentRepository;
use App\Document\User;

/**
 * Description of UserRepository
 *  http://symfony.com/doc/master/bundles/DoctrineMongoDBBundle/index.html
 * @author Pierre
 */
class UserRepository extends DocumentRepository {

    public function findByCredentials(User $user) {

        return $this->createQueryBuilder('user')
                        ->field('username')->equals($user->getUsername())
                        ->field('password')->equals($user->getPassword())
//                        ->where('user.username = :username AND user.password = :password')
//                        ->andWhere('c.password = :password')
//                        ->setParameter('username', $user->getUsername())
//                        ->setParameter('password', $user->getPassword())
                        ->getQuery()
//                        ->getOneOrNullResult();
                        ->getSingleResult();
    }

}
