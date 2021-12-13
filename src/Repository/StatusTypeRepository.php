<?php

namespace App\Repository;

use App\Entity\StatusType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method StatusType|null find($id, $lockMode = null, $lockVersion = null)
 * @method StatusType|null findOneBy(array $criteria, array $orderBy = null)
 * @method StatusType[]    findAll()
 * @method StatusType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StatusTypeRepository extends ServiceEntityRepository
{
    CONST VALID_STATUSES = ['avialible','unavialible','delivery_only','special','unused'];

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StatusType::class);
    }

    // /**
    //  * @return StatusType[] Returns an array of StatusType objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?StatusType
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
