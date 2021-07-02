<?php
declare(strict_types=1);

namespace App\Controller\Api;

use App\Action\AliPayNotifyAction;
use App\Action\GeneratePayPageAction;
use App\Action\QueryPayLogAction;
use App\Action\QueryScoreLogAction;
use App\Contract\PayInterface;
use App\Dto\Request\AliPayNotifyDto;
use App\Dto\Request\CommonQueryDto;
use App\Dto\Request\PayMentDto;
use App\Dto\Response\PayLogListResponseDto;
use App\Dto\Response\PayLogResponseDto;
use App\Dto\Response\ScoreLogListResponseDto;
use App\Dto\Response\ScoreLogResponseDto;
use App\Entity\PayOrder;
use App\Entity\ScoreBill;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class PayController
 * @package App\Controller\Api
 *
 * @Route("/api/payment")
 */
class PayController extends AbstractController
{
    /**
     * @Route("/pay",methods={"POST"})
     * @param PayMentDto $dto
     * @param GeneratePayPageAction $action
     * @return Response
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function pay(PayMentDto $dto, GeneratePayPageAction $action): Response
    {
        $data = $action->run($dto);

        if ($data->isOutputResponse()) {
            return new Response($data->getBody());
        }
        return $this->json($data->getBody());
    }

    /**
     * 支付回调接口
     * @Route("/notify",methods={"POST"})
     * @param AliPayNotifyDto $dto
     * @param PayInterface $pay
     * @param AliPayNotifyAction $action
     * @return Response
     */
    public function notify(AliPayNotifyDto $dto, PayInterface $pay, AliPayNotifyAction $action): Response
    {
        if ($pay->verifyNotify($dto->toArray())) {
            $action->run($dto);
            return new Response('success');
        } else {
            return new Response('fail');
        }
    }

    /**
     * @Route("/pay-log",methods={"POST"})
     * @param CommonQueryDto $dto
     * @param QueryPayLogAction $action
     * @return Response
     */
    public function payLog(CommonQueryDto $dto, QueryPayLogAction $action): Response
    {
        $result = $action->run($dto);
        ['total' => $total, 'list' => $list] = $result;
        $status = [1 => '待支付', 2 => '已支付', 3 => '失效'];

        $dto = new PayLogListResponseDto();
        $dto->total = $total;
        $dto->list = (array)$dto->transArrayObjects($list, function ($obj) use ($status) {
            /**@var PayOrder $obj */
            $o = new PayLogResponseDto();
            $o->orderId = $obj->getOrderId() ?? '';
            $o->serialId = $obj->getSerialId() ?? '';
            $o->payAmount = $obj->getAmount() ?? '0.00';
            $o->payType = '支付宝';
            $o->status = $status[$obj->getStatus()] ?? '未知';
            $o->createdTime = $obj->getCreatedTime()->format('Y-m-d H:i:s');
            return $o;
        });

        return $dto->transformerResponse();
    }

    /**
     * @Route("/score-log",methods={"POST"})
     * @param CommonQueryDto $dto
     * @param QueryScoreLogAction $scoreLogAction
     * @return Response
     */
    public function scoreLog(CommonQueryDto $dto, QueryScoreLogAction $scoreLogAction): Response
    {
        $result = $scoreLogAction->run($dto);
        ['total' => $total, 'list' => $list] = $result;
        $status = [1 => '充值', 2 => '任务消耗', 3 => '任务退还', 4 => '管理员赠送', 5 => '管理员清除'];

        $dto = new ScoreLogListResponseDto();
        $dto->total = $total;
        $dto->list = (array)$dto->transArrayObjects($list, function ($obj) use ($status) {
            /**@var ScoreBill $obj */
            $o = new ScoreLogResponseDto();
            $o->orderId = $obj->getOrderId() ?? '';
            $o->createdTime = $obj->getCreatedTime()->format('Y-m-d H:i:s');
            $o->amount = $obj->getAmount() ?? '';
            $o->balance = $obj->getScoreBalance() ?? '';
            $o->type = $status[$obj->getBillType()] ?? '未知';
            $o->remarks = $obj->getRemarks() ?? '';
            return $o;
        });

        return $dto->transformerResponse();
    }
}
