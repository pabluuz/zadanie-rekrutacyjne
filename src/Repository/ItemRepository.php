<?php

namespace App\Repository;

use App\Entity\Item;
use App\Entity\StatusType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Item|null find($id, $lockMode = null, $lockVersion = null)
 * @method Item|null findOneBy(array $criteria, array $orderBy = null)
 * @method Item[]    findAll()
 * @method Item[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ItemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Item::class);
    }

    public function findByStatusTypeInStatusHistory(StatusType $statusType)
    {
        $items = [];
        $histories = $this->getEntityManager()
            ->getRepository("App:StatusHistory")
            ->findBy(["statusType" => $statusType->getId()]);
        foreach ($histories as $history) {
            $items[] = $history->getItem();
        }
        return array_unique($items, SORT_REGULAR );
    }

    /*public function findOneBy(array $criteria, array $orderBy = null)
    {
        $subject = $criteria[0]
        in_array($criteria[0], self::VALID_STATUSES)
        if (in_array($criteria[0], self::VALID_STATUSES))
            return parent::findOneBy($criteria, $orderBy);
    }*/
    // /**
    //  * @return Item[] Returns an array of Item objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Item
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
