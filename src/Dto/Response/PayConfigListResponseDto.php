<?php
declare(strict_types=1);

namespace App\Dto\Response;

use App\Dto\Response\Transformer\AbstractResponseDtoTransformer;
use JMS\Serializer\Annotation as Serializer;

class PayConfigListResponseDto extends AbstractResponseDtoTransformer
{
    /**
     * @Serializer\Type("array<App\Dto\Response\PayConfigResponseDto>")
     *
     */
    public array $list;
}
