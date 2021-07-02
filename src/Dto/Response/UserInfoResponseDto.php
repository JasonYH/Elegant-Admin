<?php
declare(strict_types=1);

namespace App\Dto\Response;


use App\Dto\Response\Transformer\AbstractResponseDtoTransformer;

class UserInfoResponseDto extends AbstractResponseDtoTransformer
{
    public string $id;

    public string $parent_id;

    public string $phone;

    public string $score;

    public int $identity;

    public string $promotionCode;

    public string $promotionRevenue;

    public int $promotionPeople;
}
