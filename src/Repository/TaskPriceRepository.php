<?php

namespace App\Repository;

use App\Entity\TaskPrice;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TaskPrice|null find($id, $lockMode = null, $lockVersion = null)
 * @method TaskPrice|null findOneBy(array $criteria, array $orderBy = null)
 * @method TaskPrice[]    findAll()
 * @method TaskPrice[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TaskPriceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TaskPrice::class);
    }

    // /**
    //  * @return TaskPrice[] Returns an array of TaskPrice objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TaskPrice
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
