<?php

namespace App\Repository;

use App\Entity\Bulletin;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Bulletin|null find($id, $lockMode = null, $lockVersion = null)
 * @method Bulletin|null findOneBy(array $criteria, array $orderBy = null)
 * @method Bulletin[]    findAll()
 * @method Bulletin[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BulletinRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Bulletin::class);
    }

    public function findLastOne(): ?Bulletin
    {
        try {
            $query = $this->createQueryBuilder('t')
                ->orderBy('t.id', 'DESC')
                ->getQuery();
            return $query->getOneOrNullResult();
        } catch (NonUniqueResultException $e) {
            return null;
        }
    }
}
