<?php
declare(strict_types=1);

namespace App\Dto\Response;

use App\Dto\Response\Transformer\AbstractResponseDtoTransformer;

class WithdrawBillResponstDto extends AbstractResponseDtoTransformer
{
    public string $amount;

    public string $accountNumber;

    public string $accountName;

    public string $type;

    public string $createdTime;

    public string $status;
}
