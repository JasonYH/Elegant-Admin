<?php
declare(strict_types=1);

namespace App\Dto\Response;

use App\Dto\Response\Transformer\AbstractResponseDtoTransformer;

class PayLogResponseDto extends AbstractResponseDtoTransformer
{
    public string $orderId;

    public string $payAmount;

    public string $payType;

    public string $createdTime;

    public string $serialId;

    public string $status;
}

