<?php

namespace App\Repository;

use App\Entity\PayConfig;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PayConfig|null find($id, $lockMode = null, $lockVersion = null)
 * @method PayConfig|null findOneBy(array $criteria, array $orderBy = null)
 * @method PayConfig[]    findAll()
 * @method PayConfig[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PayConfigRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PayConfig::class);
    }
}
