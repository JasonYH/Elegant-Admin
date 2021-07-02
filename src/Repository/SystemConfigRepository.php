<?php

namespace App\Repository;

use App\Entity\SystemConfig;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SystemConfig|null find($id, $lockMode = null, $lockVersion = null)
 * @method SystemConfig|null findOneBy(array $criteria, array $orderBy = null)
 * @method SystemConfig[]    findAll()
 * @method SystemConfig[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SystemConfigRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SystemConfig::class);
    }

    /**
     * 通过 type 获取 配置项的key=>value
     * @param int $type
     * @return array
     */
    public function getTypeConfigMap(int $type): array
    {
        $query = $this->createQueryBuilder('location')
            ->where('location.type = :type')
            ->setParameter('type', $type)
            ->getQuery();
        $data = $query->getArrayResult();
        return array_column($data, 'value', 'config_key');
    }

    /**
     * 通过给定的key 获取内容
     * @param mixed ...$key
     * @return array
     */
    public function getValueByKey(...$key): array
    {
        $query = $this->createQueryBuilder('t')
            ->where('t.config_key IN (:keys)')
            ->setParameter('keys', $key)
            ->getQuery();
        $data = $query->getArrayResult();
        return array_column($data, 'value', 'config_key');
    }
}
