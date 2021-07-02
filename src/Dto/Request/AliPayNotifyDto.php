<?php
declare(strict_types=1);

namespace App\Dto\Request;

use App\Dto\Request\Transformer\AbstractRequestDtoTransformer;

class AliPayNotifyDto extends AbstractRequestDtoTransformer
{
    //编码格式
    public string $charset;

    //通知的发送时间
    public string $notifyTime;

    //签名
    public string $sign;

    //调用的接口版本。固定为：1.0。
    public string $version;

    //通知校验 ID。
    public string $notifyId;

    //通知类型。
    public string $notifyType;

    //商户订单号。原支付请求的商户订单号。
    public string $outTradeNo;

    //支付宝交易号。支付宝交易凭证号
    public string $tradeNo;

    //授权方的 appid。由于本接口暂不开放第三方应用授权，因此 auth_app_id=app_id。
    public string $authAppId;

    //用户在交易中支付的金额，单位为元，精确到小数点付款金额。后 2 位。
    public string $buyerPayAmount;

    //开发者的 app_id。
    public string $appId;

    //签名类型。签名算法类型，目前支持 RSA2 和 RSA，
    public string $signType;

    //交易创建时间。该笔交易创建的时间
    public ?string $gmtCreate;

    //交易付款时间
    public ?string $gmtPayment;

    //订单标题
    public ?string $subject;

    //买家支付宝用户号
    public ?string $buyerId;

    //开票金额
    public ?string $invoiceAmount;

    //支付金额信息。支付成功的各个渠道金额信息
    public ?string $fundBillList;

    //订单金额。本次交易支付的订单金额，单位为人民币（元），精确到小数点后 2 位。
    public ?string $totalAmount;

    /**
     * 交易状态。交易目前所处的状态
     * WAIT_BUYER_PAY    交易创建，等待买家付款。
     * TRADE_CLOSED    未付款交易超时关闭，或支付完成后全额退款。
     * TRADE_SUCCESS    交易支付成功。
     * TRADE_FINISHED    交易结束，不可退款。
     */
    public ?string $tradeStatus;

    //实收金额。商家在交易中实际收到的款项，单位为元，精确到小数点后 2 位。
    public ?string $receiptAmount;

    //集分宝金额。使用集分宝支付的金额，单位为元，精确到小数点后 2 位。
    public ?string $pointAmount;

    //卖家支付宝用户号
    public ?string $sellerId;
}
