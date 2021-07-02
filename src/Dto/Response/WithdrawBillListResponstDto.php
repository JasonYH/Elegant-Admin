<?php
declare(strict_types=1);

namespace App\Dto\Response;

use App\Dto\Response\Transformer\AbstractResponseDtoTransformer;
use JMS\Serializer\Annotation as Serializer;

class WithdrawBillListResponstDto extends AbstractResponseDtoTransformer
{
    public int $total;

    /**
     * @Serializer\Type("array<App\Dto\Response\WithdrawBillResponstDto>")
     */
    public array $list;
}
