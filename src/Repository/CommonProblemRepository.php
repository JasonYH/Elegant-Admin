<?php

namespace App\Repository;

use App\Entity\CommonProblem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CommonProblem|null find($id, $lockMode = null, $lockVersion = null)
 * @method CommonProblem|null findOneBy(array $criteria, array $orderBy = null)
 * @method CommonProblem[]    findAll()
 * @method CommonProblem[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommonProblemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CommonProblem::class);
    }

    // /**
    //  * @return CommonProblem[] Returns an array of CommonProblem objects
    //  */
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
    public function findOneBySomeField($value): ?CommonProblem
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
