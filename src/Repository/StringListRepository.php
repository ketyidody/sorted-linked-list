<?php

namespace App\Repository;

use App\Entity\StringList;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<StringList>
 *
 * @method StringList|null find($id, $lockMode = null, $lockVersion = null)
 * @method StringList|null findOneBy(array $criteria, array $orderBy = null)
 * @method StringList[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StringListRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StringList::class);
    }

    // I see no reason here to use linked list logic, so I just return all the entities ordered by name
    public function findAll()
    {
        return $this
            ->createQueryBuilder('s')
            ->orderBy('s.name', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
