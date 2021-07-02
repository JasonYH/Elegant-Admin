<?php
declare(strict_types=1);

namespace App\Dto\Response;

use App\Dto\Response\Transformer\AbstractResponseDtoTransformer;
use JMS\Serializer\Annotation as Serializer;

class TaskPricesResponseDto extends AbstractResponseDtoTransformer
{
    /**
     * @Serializer\Type("array<App\Dto\Response\TaskPriceResponseDto>")
     *
     */
    public array $list;


    public string $payProportion;

}
