<?php

namespace App\Repository;

use App\Dto\Request\AliPayNotifyDto;
use App\Dto\Request\CommonQueryDto;
use App\Entity\PayOrder;
use App\Entity\User;
use App\Utils\OrderNoUtils;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;
use Exception;

/**
 * @method PayOrder|null find($id, $lockMode = null, $lockVersion = null)
 * @method PayOrder|null findOneBy(array $criteria, array $orderBy = null)
 * @method PayOrder[]    findAll()
 * @method PayOrder[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PayOrderRepository extends ServiceEntityRepository
{
    private UserRepository $userRepository;

    private SystemConfigRepository $systemConfigRepository;

    public function __construct(
        ManagerRegistry $registry,
        UserRepository $userRepository,
        SystemConfigRepository $systemConfigRepository
    ) {
        parent::__construct($registry, PayOrder::class);

        $this->userRepository = $userRepository;
        $this->systemConfigRepository = $systemConfigRepository;
    }

    /**
     * @param User $user
     * @param string $amount
     * @param int $freeScore
     * @return PayOrder
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function addPayOrder(User $user, string $amount, int $freeScore): PayOrder
    {
        //上级用户
        $parentUser = $this->userRepository->find($user->getParentId());
        $key = sprintf("vip%d_rebate", $parentUser->getIdentity());
        //系统配置[对应等级抽用比例，充值比例]
        $config = $this->systemConfigRepository->getValueByKey($key, 'pay_proportion');
        $payRakeProportion = $config[$key] ?? 0;
        $payProportion = $config['pay_proportion'] ?? 0;
        //抽佣总金额 根据比例计算
        $payRakeTotal = bcmul($amount, bcdiv($payRakeProportion, '100', 2), 2);
        //充值总积分 根据比例计算
        $scoreTotal = bcadd(bcmul($amount, $payProportion, 2), (string)$freeScore, 2);

        $outTradeNo = OrderNoUtils::generatePayTradeNo($user->getUsername());

        $order = new PayOrder();

        //设置用户id
        $order->setUserId($user->getId());
        //设置上级id
        $order->setParentId($user->getParentId());
        //设置充值总金额
        $order->setAmount($amount);
        //设置订单ID
        $order->setOrderId($outTradeNo);
        //设置此单抽佣比例
        $order->setPayRakeProportion((int)$payRakeProportion);
        //设置此单抽用总金额
        $order->setPayRakeTotal($payRakeTotal);
        //设置支付方式
        $order->setPayType(1);
        //设置积分充值比例
        $order->setScorePayProportion((int)$payProportion);
        //设置积分充值总额
        $order->setScoreTotal($scoreTotal);
        //第三方支付流水号
        $order->setSerialId('');
        //支付状态
        $order->setStatus(1);

        $this->_em->persist($order);
        $this->_em->flush();
        return $order;
    }

    /**
     * 更改充值记录订单状态
     * @param AliPayNotifyDto $dto
     * @return PayOrder
     * @throws ORMException
     * @throws OptimisticLockException
     * @throws Exception
     */
    public function setPayStatusSuccess(AliPayNotifyDto $dto): PayOrder
    {
        $order = $this->findOneBy(['orderId' => $dto->outTradeNo]);

        //订单状态已异常
        if ($order->getStatus() !== 1) {
            throw new Exception('订单状态异常');
        }
        //金额不符
        if ($dto->receiptAmount !== $order->getAmount()) {
            throw new Exception('支付金额与订单不符');
        }

        $order->setSerialId($dto->tradeNo);
        $order->setStatus(2);
        $this->_em->persist($order);
        $this->_em->flush();
        return $order;
    }

    /**
     * 查询账单
     * @param CommonQueryDto $dto
     * @param User $user
     * @return array
     */
    public function queryUserPayLog(CommonQueryDto $dto, User $user): array
    {
        $offset = ($dto->page - 1) * $dto->pageCount;

        $qb = $this->_em->createQueryBuilder();
        $qb->select('p')->from($this->getEntityName(), 'p');
        $qb->orderBy('p.createdTime', 'DESC');
        $qb->where('p.userId = :userid')->setParameter('userid', $user->getId());

        if (!empty($dto->searchKey)) {
            $qb->andWhere('p.orderId = :searchKey')->setParameter('searchKey', $dto->searchKey);
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
