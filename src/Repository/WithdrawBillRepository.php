<?php

namespace App\Repository;

use App\Dto\Request\CommonQueryDto;
use App\Entity\User;
use App\Entity\WithdrawBill;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method WithdrawBill|null find($id, $lockMode = null, $lockVersion = null)
 * @method WithdrawBill|null findOneBy(array $criteria, array $orderBy = null)
 * @method WithdrawBill[]    findAll()
 * @method WithdrawBill[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WithdrawBillRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WithdrawBill::class);
    }

    /**
     * 查询提现记录
     * @param CommonQueryDto $dto
     * @param User $user
     * @return array
     */
    public function queryWithdrawBill(CommonQueryDto $dto, User $user): array
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
