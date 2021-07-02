<?php
declare(strict_types=1);

namespace App\Action;

use App\Dto\Request\AliPayNotifyDto;
use App\Repository\PayOrderRepository;
use App\Repository\PromoteGainRepository;
use App\Repository\ScoreBillRepository;
use App\Repository\UserRepository;
use App\Task\UpdateUserInfoCacheTask;
use Doctrine\Persistence\ManagerRegistry;
use Exception;

class AliPayNotifyAction
{
    private PayOrderRepository $payOrderRepository;

    private UserRepository $userRepository;

    private ScoreBillRepository $scoreBillRepository;

    private PromoteGainRepository $promoteGainRepository;

    private ManagerRegistry $managerRegistry;

    private UpdateUserInfoCacheTask $updateUserInfoCacheTask;

    public function __construct(
        PayOrderRepository $payOrderRepository,
        UserRepository $userRepository,
        ScoreBillRepository $scoreBillRepository,
        PromoteGainRepository $promoteGainRepository,
        ManagerRegistry $managerRegistry,
        UpdateUserInfoCacheTask $updateUserInfoCacheTask
    ) {
        $this->payOrderRepository = $payOrderRepository;
        $this->userRepository = $userRepository;
        $this->scoreBillRepository = $scoreBillRepository;
        $this->promoteGainRepository = $promoteGainRepository;
        $this->managerRegistry = $managerRegistry;
        $this->updateUserInfoCacheTask = $updateUserInfoCacheTask;
    }

    public function run(AliPayNotifyDto $dto): bool
    {
        if ($dto->tradeStatus !== 'TRADE_SUCCESS') {
            return false;
        }
        $em = $this->managerRegistry->getConnection();
        $em->beginTransaction();
        try {
            //更改充值记录订单状态
            $order = $this->payOrderRepository->setPayStatusSuccess($dto);
            //给自己增加积分
            $user = $this->userRepository->setPayScore($order);
            //给上级抽佣金
            $parentUser = $this->userRepository->setParentRake($order);
            //增加自己积分日志
            $this->scoreBillRepository->addPayScoreBillLog($order,$user);
            //给上级增加佣金日志
            $this->promoteGainRepository->addGainBillLog($order,$parentUser);
            $em->commit();
            //更新缓存
            $this->updateUserInfoCacheTask->run($user);
            $this->updateUserInfoCacheTask->run($parentUser);
            return true;
        } catch (Exception $ex) {
            $em->rollBack();
            return false;
        }
    }
}
