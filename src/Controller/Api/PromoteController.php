<?php
declare(strict_types=1);

namespace App\Controller\Api;

use App\Action\QueryPromoteGainListAction;
use App\Action\QueryPromoteUserListAction;
use App\Action\QueryWithdrawBillListAction;
use App\Dto\Request\CommonQueryDto;
use App\Dto\Response\PromoteGainListResponseDto;
use App\Dto\Response\PromoteGainResponseDto;
use App\Dto\Response\PromoteUserListResponseDto;
use App\Dto\Response\PromoteUserResponseDto;
use App\Dto\Response\WithdrawBillListResponstDto;
use App\Dto\Response\WithdrawBillResponstDto;
use App\Entity\PromoteGain;
use App\Entity\User;
use App\Entity\WithdrawBill;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class PromoteController
 * @package App\Controller\Api
 *
 * @Route("/api/promote")
 */
class PromoteController extends AbstractController
{
    /**
     * @Route("/promote-user",methods={"POST"})
     * @param CommonQueryDto $dto
     * @param QueryPromoteUserListAction $action
     * @return Response
     */
    public function promoteUserList(CommonQueryDto $dto, QueryPromoteUserListAction $action): Response
    {
        $result = $action->run($dto);
        ['total' => $total, 'list' => $list] = $result;
        $status = [1 => '普通会员', 2 => '金牌会员', 3 => '金牌会员', 4 => '超级会员', 5 => '代理会员'];
        $dto = new PromoteUserListResponseDto();
        $dto->total = $total;
        $dto->list = (array)$dto->transArrayObjects($list, function ($obj) use ($status) {
            /**@var User $obj */
            $o = new PromoteUserResponseDto();
            $o->createdTime = $obj->getCreatedTime()->format('Y-m-d H:i:s');
            $o->amount = $obj->getPayTotal() ?? '0.00';
            $o->phone = $obj->getPhone() ?? '';
            $o->beBrokerageTotal = $obj->getBeBrokerageTotal() ?? '0.00';
            $o->level = $status[$obj->getIdentity()] ?? '';
            return $o;
        });

        return $dto->transformerResponse();
    }

    /**
     * @Route("/promote-gain",methods={"POST"})
     * @param CommonQueryDto $dto
     * @param QueryPromoteGainListAction $action
     * @return Response
     */
    public function promoteGainList(CommonQueryDto $dto, QueryPromoteGainListAction $action): Response
    {
        $result = $action->run($dto);
        ['total' => $total, 'list' => $list] = $result;
        $dto = new PromoteGainListResponseDto();
        $dto->total = $total;
        $dto->list = (array)$dto->transArrayObjects($list, function ($obj) {
            /**@var PromoteGain $obj */
            $o = new PromoteGainResponseDto();
            $o->createdTime = $obj->getCreatedTime()->format('Y-m-d H:i:s');
            $o->orderId = $obj->getOrderId() ?? '';
            $o->payRakeTotal = $obj->getPayRakeTotal() ?? '0.00';
            $o->summary = $obj->getSummary() ?? '';
            $o->balance = $obj->getBalance() ?? '0.00';
            return $o;
        });

        return $dto->transformerResponse();
    }

    /**
     * @Route("/withdraw-bill",methods={"POST"})
     * @param CommonQueryDto $dto
     * @param QueryWithdrawBillListAction $action
     * @return Response
     */
    public function withdrawBillList(CommonQueryDto $dto, QueryWithdrawBillListAction $action): Response
    {
        $result = $action->run($dto);
        ['total' => $total, 'list' => $list] = $result;
//        结算状态[1-审核中，2-已结算，3-已拒绝]
        $status = [1=>'审核中',2=>'已结算',3=>'已拒绝'];
        $type = [1=>'支付宝',2=>'微信',3=>'银行卡'];
        $dto = new WithdrawBillListResponstDto();
        $dto->total = $total;
        $dto->list = (array)$dto->transArrayObjects($list, function ($obj) use($status,$type) {
            /**@var WithdrawBill $obj */
            $o = new WithdrawBillResponstDto();
            $o->createdTime = $obj->getCreatedTime()->format('Y-m-d H:i:s');
            $o->amount = $obj->getAmount() ?? '0.00';
            $o->accountName = $obj->getAccountName() ?? '';
            $o->accountNumber = $obj->getAccountNumber() ?? '';
            $o->type = $type[$obj->getType()]  ?? '';
            $o->status = $status[$obj->getStatus()] ?? '';
            return $o;
        });

        return $dto->transformerResponse();
    }




}
