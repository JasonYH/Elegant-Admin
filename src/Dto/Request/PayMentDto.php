<?php
declare(strict_types=1);

namespace App\Dto\Request;

use App\Dto\Request\Transformer\AbstractRequestDtoTransformer;
use Symfony\Component\Validator\Constraints as Assert;

class PayMentDto extends AbstractRequestDtoTransformer
{
    /**
     * 充值套餐id
     * @Assert\NotBlank(message="充值模式id不能为空")
     */
    public int $payId;

    /**
     * 自定义充值模式
     * @Assert\Type("bool")
     */
    public bool $isDiy = false;

    /**
     * 自定义充值模式下充值金额
     * @Assert\NotBlank(message="充值总金额不能为空")
     */
    public string $payAmount = '0';
}
