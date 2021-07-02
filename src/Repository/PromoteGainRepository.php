<?php

namespace App\Repository;

use App\Dto\Request\CommonQueryDto;
use App\Entity\PayOrder;
use App\Entity\PromoteGain;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PromoteGain|null find($id, $lockMode = null, $lockVersion = null)
 * @method PromoteGain|null findOneBy(array $criteria, array $orderBy = null)
 * @method PromoteGain[]    findAll()
 * @method PromoteGain[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PromoteGainRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PromoteGain::class);
    }

    /**
     * 给上级增加佣金日志
     * @param PayOrder $order
     * @param User|null $parentUser
     * @return PromoteGain
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function addGainBillLog(PayOrder $order, ?User $parentUser): PromoteGain
    {
        $gainLog = new PromoteGain();
        $gainLog->setUserId($parentUser->getId());
        $gainLog->setOrderId($order->getOrderId());
        $gainLog->setSummary('客户充值奖励');
        $gainLog->setPayRakeProportion($order->getPayRakeProportion());
        $gainLog->setPayRakeTotal($order->getPayRakeTotal());
        $gainLog->setBalance($parentUser->getPromotionRevenue());
        $gainLog->setType(1);
        $this->_em->persist($gainLog);
        $this->_em->flush();
        return $gainLog;
    }

    /**
     * 查询返现记录清单
     * @param CommonQueryDto $dto
     * @param User $user
     * @return array
     */
    public function queryPromoteGainList(CommonQueryDto $dto, User $user): array
    {
        $offset = ($dto->page - 1) * $dto->pageCount;

        $qb = $this->_em->createQueryBuilder();
        $qb->select('p')->from($this->getEntityName(), 'p');
        $qb->orderBy('p.createdTime', 'DESC');
        $qb->where('p.userId = :userid')->setParameter('userid', $user->getId());

        $qb->setMaxResults($dto->pageCount)->setFirstResult($offset);

        $paginator = new Paginator($qb, false);

        return ['total' => $paginator->count(), 'list' => $paginator->getQuery()->getResult()];
    }
}
