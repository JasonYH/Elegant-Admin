<?php

namespace App\Repository;

use App\Dto\Request\CommonQueryDto;
use App\Entity\PayOrder;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\LockMode;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;
use Exception;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * @param $value
     * @return User|null
     */
    public function findByPhoneField($value): ?User
    {
        return $this->findOneBy(['phone' => $value]);
    }

    public function findByPromotionCodeProField($value): ?User
    {
        return  $this->findOneBy(['promotionCode' => $value]);
    }

    public function incrementPromotionPeople(string $userid)
    {
        $this->_em->getConnection()->beginTransaction();
        try {
            $user = $this->find($userid, LockMode::PESSIMISTIC_WRITE);
            $user->setPromotionPeople($user->getPromotionPeople() + 1);
            $this->_em->persist($user);
            $this->_em->flush();
            $this->_em->getConnection()->commit();
        }catch (Exception $ex){
            $this->_em->getConnection()->rollBack();
        }

    }

    /**
     * @param $value
     * @return User|null
     */
    public function findByIdField($value): ?User
    {
        return $this->findOneBy(['id' => $value]);
    }

    /**
     * 给自己增加积分
     * @param PayOrder $order
     * @return User|null
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function setPayScore(PayOrder $order): ?User
    {
        $user = $this->find($order->getUserId(),LockMode::PESSIMISTIC_WRITE);

        //累加充值总金额
        $user->setPayTotal(bcadd($order->getAmount(), $user->getPayTotal(), 2));
        //累加被抽佣金总计
        $user->setBeBrokerageTotal(bcadd($user->getBeBrokerageTotal(), $order->getPayRakeTotal(), 2));
        //设置用户积分
        $user->setScore(bcadd($order->getScoreTotal(), $user->getScore(), 2));
        $this->_em->persist($user);
        $this->_em->flush();
        return $user;
    }

    /**
     * 给上级抽佣金
     * @param PayOrder $order
     * @return User|null
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function setParentRake(PayOrder $order): ?User
    {
        $parentUser = $this->find($order->getParentId(),LockMode::PESSIMISTIC_WRITE);
        $parentUser->setPromotionRevenue(bcadd($parentUser->getPromotionRevenue(), $order->getPayRakeTotal(), 2));
        $this->_em->persist($parentUser);
        $this->_em->flush();
        return $parentUser;
    }

    /**
     * 查询自己的下级用户
     * @param CommonQueryDto $dto
     * @param User $user
     * @return array
     */
    public function queryPromoteUser(CommonQueryDto $dto, User $user): array
    {

        $offset = ($dto->page - 1) * $dto->pageCount;

        $qb = $this->_em->createQueryBuilder();
        $qb->select('p')->from($this->getEntityName(), 'p');
        $qb->orderBy('p.createdTime', 'DESC');
        $qb->where('p.parentId = :userid')->setParameter('userid', $user->getId());

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
