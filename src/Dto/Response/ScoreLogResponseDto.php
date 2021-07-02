<?php
declare(strict_types=1);

namespace App\Dto\Response;


use App\Dto\Response\Transformer\AbstractResponseDtoTransformer;

class ScoreLogResponseDto extends AbstractResponseDtoTransformer
{
    public string $createdTime;

    public string $amount;

    public string $balance;

    public string $orderId;

    public string $type;

    public string $remarks;
}
