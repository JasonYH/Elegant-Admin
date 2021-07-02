<?php
declare(strict_types=1);

namespace App\Dto\Response;

use App\Dto\Response\Transformer\AbstractResponseDtoTransformer;
use JMS\Serializer\Annotation as Serializer;

class PromoteUserListResponseDto extends AbstractResponseDtoTransformer
{
    public int $total;

    /**
     * @Serializer\Type("array<App\Dto\Response\PromoteUserResponseDto>")
     */
    public array $list;
}
