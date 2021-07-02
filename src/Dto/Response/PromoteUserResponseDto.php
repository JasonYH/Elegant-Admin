<?php
declare(strict_types=1);

namespace App\Dto\Response;

use App\Dto\Response\Transformer\AbstractResponseDtoTransformer;

class PromoteUserResponseDto extends AbstractResponseDtoTransformer
{
    public string $createdTime;

    public string $phone;

    public string $level;

    public string $beBrokerageTotal;

    public string $amount;
}
