<?php

namespace App\Repository;

use App\Dto\Request\CommonQueryDto;
use App\Entity\PayOrder;
use App\Entity\ScoreBill;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ScoreBill|null find($id, $lockMode = null, $lockVersion = null)
 * @method ScoreBill|null findOneBy(array $criteria, array $orderBy = null)
 * @method ScoreBill[]    findAll()
 * @method ScoreBill[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ScoreBillRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ScoreBill::class);
    }

    /**
     * @param PayOrder $order
     * @param User $user
     * @return ScoreBill
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function addPayScoreBillLog(PayOrder $order, User $user): ScoreBill
    {
        $bill = new ScoreBill();
        $bill->setOrderId($order->getOrderId());
        $bill->setUserId($order->getUserId());
        $bill->setAmount($order->getAmount());
        $bill->setScoreBalance($user->getScore());
        $bill->setBillType(1);
        $bill->setRemarks('积分充值');

        $this->_em->persist($bill);
        $this->_em->flush();
        return $bill;

    }




    /**
     * 查询账单
     * @param CommonQueryDto $dto
     * @param User $user
     * @return array
     */
    public function queryUserScoreLog(CommonQueryDto $dto, User $user): array
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->select('p')->from($this->getEntityName(), 'p');
        $qb->orderBy('p.createdTime', 'DESC');
        $qb->where('p.userId = :userid')->setParameter('userid', $user->getId());

        $offset = ($dto->page - 1) * $dto->pageCount;
        if (!empty($dto->searchKey)) {
            $qb->andWhere('p.orderId = :searchKey')->setParameter('searchKey', $dto->searchKey);
        }

        if (!empty($dto->type)) {
            $qb->andWhere('p.billType = :type')->setParameter('type', $dto->type);
        }

        if (!empty($dto->strDate) && !empty($dto->endDate)) {
            $qb->andWhere($qb->expr()->between('p.createdTime', ':strDate', ':endDate'))
                ->setParameter('strDate', $dto->strDate)
                ->setParameter('endDate', $dto->endDate);
        }

        $qb->setMaxResults($dto->pageCount)->setFirstResult($offset);

        $paginator = new Paginator($qb, false);

        return ['total' => $paginator->count(), 'list' => $paginator->getQuery()->getResult()];
    }

}
