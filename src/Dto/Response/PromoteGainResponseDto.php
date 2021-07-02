<?php
declare(strict_types=1);

namespace App\Dto\Response;

use App\Dto\Response\Transformer\AbstractResponseDtoTransformer;

class PromoteGainResponseDto extends AbstractResponseDtoTransformer
{
    public string $summary;

    public string $orderId;

    public string $payRakeTotal;

    public string $balance;

    public string $createdTime;
}
