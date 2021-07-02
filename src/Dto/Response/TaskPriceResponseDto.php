<?php
declare(strict_types=1);

namespace App\Dto\Response;

use App\Dto\Response\Transformer\AbstractResponseDtoTransformer;

class TaskPriceResponseDto extends AbstractResponseDtoTransformer
{
    public int $id;

    public string $name;

    public string $vip1Price;

    public string $vip1PayPrice;

    public string $vip2Price;

    public string $vip2PayPrice;

    public string $vip3Price;

    public string $vip3PayPrice;

    public string $vip4Price;

    public string $vip4PayPrice;

    public string $vip5Price;

    public string $vip5PayPrice;
}
