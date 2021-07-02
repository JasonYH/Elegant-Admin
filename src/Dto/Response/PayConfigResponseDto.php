<?php
declare(strict_types=1);

namespace App\Dto\Response;

use App\Dto\Response\Transformer\AbstractResponseDtoTransformer;

class PayConfigResponseDto extends AbstractResponseDtoTransformer
{
    public int $id;

    public int $amount;

    public int $identity;

    public string $identityTag;

    public int $freeScore;

    public string $scoreTotal;
}
