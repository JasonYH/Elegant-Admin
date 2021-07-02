<?php
declare(strict_types=1);

namespace App\Controller\Api;

use App\Action\GetAllCommonProblemAction;
use App\Action\GetPayOptionsConfigAction;
use App\Action\GetSystemConfigAction;
use App\Action\GetTaskPriceAction;
use App\Dto\Response\CommonProblemListResponseDto;
use App\Dto\Response\CommonProblemResponseDto;
use App\Dto\Response\ConfigsResponseDto;
use App\Dto\Response\CustomerServiceInfoResponseDto;
use App\Dto\Response\PayConfigListResponseDto;
use App\Dto\Response\PayConfigResponseDto;
use App\Dto\Response\TaskPriceResponseDto;
use App\Dto\Response\TaskPricesResponseDto;
use App\Entity\CommonProblem;
use App\Entity\PayConfig;
use App\Entity\TaskPrice;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class SystemCommonController
 * @package App\Controller\Api
 *
 * @Route("/api/system")
 */
class SystemCommonController extends AbstractController
{
    /**
     * @Route("/get-common-problem",methods={"GET"})
     * @param GetAllCommonProblemAction $action
     * @param CommonProblemListResponseDto $dto
     * @return Response
     */
    public function getCommonProblem(GetAllCommonProblemAction $action, CommonProblemListResponseDto $dto): Response
    {
        $arrayobj = $action->run();

        $list = $dto->transArrayObjects($arrayobj, function ($obj) {
            /**@var CommonProblem $obj */
            $d = new CommonProblemResponseDto();
            $d->title = $obj->getTitle() ?? '';
            $d->content = $obj->getContent() ?? '';
            return $d;
        });

        $dto->list = (array)$list;

        return $dto->transformerResponse();
    }

    /**
     * @Route("/get-customer-service-info",methods={"GET"})
     * @param GetSystemConfigAction $action
     * @param CustomerServiceInfoResponseDto $dto
     * @return Response
     */
    public function getCustomerServiceInfo(
        GetSystemConfigAction $action,
        CustomerServiceInfoResponseDto $dto
    ): Response {
        $configs = $action->run('kefu_qq', 'kefu_wechat', 'kefu_wechat_qrc');

        $dto->qq = $configs['kefu_qq'] ?? '';
        $dto->wechat = $configs['kefu_wechat'] ?? '';
        $dto->wechatQrc = $configs['kefu_wechat_qrc'] ?? '';

        return $dto->transformerResponse();
    }

    /**
     * @Route("/get-vip-rebate")
     * @param GetSystemConfigAction $action
     * @param ConfigsResponseDto $dto
     * @return Response
     */
    public function getVipRebate(
        GetSystemConfigAction $action,
        ConfigsResponseDto $dto
    ): Response {
        $data = $action->run('vip1_rebate', 'vip2_rebate', 'vip3_rebate', 'vip4_rebate');
        $dto->configs = $data;
        return $dto->transformerResponse();
    }

    /**
     * @Route("/get-task-price",methods={"GET"})
     *
     * @param GetSystemConfigAction $systemConfigAction
     * @param GetTaskPriceAction $taskPriceAction
     * @param TaskPricesResponseDto $dto
     * @return Response
     */
    public function getTaskPrice(
        GetSystemConfigAction $systemConfigAction,
        GetTaskPriceAction $taskPriceAction,
        TaskPricesResponseDto $dto
    ): Response {
        $list = $taskPriceAction->run();

        $configs = $systemConfigAction->run('pay_proportion');
        $payPrice = $configs['pay_proportion'] ?? '0';

        $dto->payProportion = $payPrice;
        $dto->list = (array)$dto->transArrayObjects($list, function ($obj) use ($payPrice) {
            /**@var TaskPrice $obj */
            $d = new TaskPriceResponseDto();
            $d->id = $obj->getId() ?? 0;
            $d->name = $obj->getName() ?? '';

            $d->vip1Price = $obj->getVip1Price() ?? '0';
            $d->vip1PayPrice = bcdiv($d->vip1Price,$payPrice,3)??'0';

            $d->vip2Price = $obj->getVip2Price() ?? '0';
            $d->vip2PayPrice = bcdiv($d->vip2Price,$payPrice,3)??'0';

            $d->vip3Price = $obj->getVip3Price() ?? '0';
            $d->vip3PayPrice = bcdiv($d->vip3Price,$payPrice,3)??'0';

            $d->vip4Price = $obj->getVip4Price() ?? '0';
            $d->vip4PayPrice = bcdiv($d->vip4Price, $payPrice, 3) ?? '0';

            $d->vip5Price = $obj->getVip5Price() ?? '0';
            $d->vip5PayPrice = bcdiv($d->vip5Price, $payPrice, 3) ?? '0';
            return $d;
        });
        return $dto->transformerResponse();
    }

    /**
     * @Route("/get-pay-config",methods={"GET"})
     * @param GetPayOptionsConfigAction $payOptionsConfigAction
     * @param GetSystemConfigAction $systemConfigAction
     * @param PayConfigListResponseDto $dto
     * @return Response
     */
    public function getPayConfig(
        GetPayOptionsConfigAction $payOptionsConfigAction,
        GetSystemConfigAction $systemConfigAction,
        PayConfigListResponseDto $dto
    ): Response {
        $list = $payOptionsConfigAction->run();
        $configs = $systemConfigAction->run('pay_proportion');
        $payPrice = $configs['pay_proportion'] ?? '0';

        $identityTag = [1 => '普通会员', 2 => '金牌会员', 3 => '钻石会员', 4 => '超级会员'];

        $dto->list = (array)$dto->transArrayObjects($list, function ($obj) use ($payPrice, $identityTag) {
            /**@var PayConfig $obj */
            $d = new PayConfigResponseDto();
            $d->id = $obj->getId() ?? 0;
            $d->amount = $obj->getAmount() ?? 0;
            $d->identity = $obj->getIdentity() ?? 0;
            $d->identityTag = $identityTag[$d->identity];
            $d->freeScore = $obj->getFreeScore() ?? 0;
            $d->scoreTotal = bcdiv(bcmul((string)$d->amount, $payPrice), '10000') ?? '0';
            return $d;
        });
        return $dto->transformerResponse();
    }
}
