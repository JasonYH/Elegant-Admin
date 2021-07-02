<?php
declare(strict_types=1);

namespace App\Action;

use App\Contract\PayInterface;
use App\Dto\Request\PayMentDto;
use App\Entity\User;
use App\Repository\PayConfigRepository;
use App\Repository\PayOrderRepository;
use App\Service\Pay\Dto\PayTradeDto;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Component\Security\Core\Security;

class GeneratePayPageAction
{
    private PayInterface $payInterface;

    private Security $security;

    private PayConfigRepository $payConfigRepository;

    private PayOrderRepository $payOrderRepository;

    /**
     * GeneratePayPageAction constructor.
     * @param PayInterface $payInterface
     * @param Security $security
     * @param PayConfigRepository $payConfigRepository
     * @param PayOrderRepository $payOrderRepository
     */
    public function __construct(
        PayInterface $payInterface,
        Security $security,
        PayConfigRepository $payConfigRepository,
        PayOrderRepository $payOrderRepository
    ) {
        $this->payInterface = $payInterface;
        $this->security = $security;
        $this->payConfigRepository = $payConfigRepository;
        $this->payOrderRepository = $payOrderRepository;
    }

    /**
     * @param PayMentDto $dto
     * @return PayTradeDto
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function run(PayMentDto $dto): PayTradeDto
    {
        /** @var User $u */
        $u = $this->security->getUser();

        if ($dto->isDiy) {
            $subject = '自定义充值';
            $amount = $dto->payAmount;
            $freeScore = 0;
        } else {
            $payConfig = $this->payConfigRepository->find($dto->payId);
            $freeScore = $payConfig->getFreeScore();
            $subject = sprintf("充值 %d 元，赠送 %d，积分", $payConfig->getAmount(), $payConfig->getFreeScore());
            $amount = (string)$payConfig->getAmount();
        }
        //生成充值订单
        $order = $this->payOrderRepository->addPayOrder($u, $amount, $freeScore);
        return $this->payInterface->pay($subject, $order->getOrderId(), $amount);
    }
}
