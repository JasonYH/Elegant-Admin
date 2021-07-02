<?php
declare(strict_types=1);

namespace App\Dto\Response;

use App\Dto\Response\Transformer\AbstractResponseDtoTransformer;
use JMS\Serializer\Annotation as Serializer;

class CommonProblemListResponseDto extends AbstractResponseDtoTransformer
{
    /**
     * @Serializer\Type("array<App\Dto\Response\CommonProblemResponseDto>")
     *
     */
    public array $list;
}
