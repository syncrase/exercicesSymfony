<?php

namespace App\Repository;

use App\Document\TimelineItem;
use Doctrine\ODM\MongoDB\DocumentRepository;

/**
 * @ method Concept|null find($id, $lockMode = null, $lockVersion = null)
 * @ method Concept|null findOneBy(array $criteria, array $orderBy = null)
 * @ method Concept[]    findAll()
 * @ method Concept[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TimelineItemRepository extends DocumentRepository {
    
    
}