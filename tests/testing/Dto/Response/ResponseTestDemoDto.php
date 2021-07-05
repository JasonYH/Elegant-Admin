<?php
declare(strict_types=1);

namespace App\Tests\testing\Dto\Response;

use App\Dto\Response\Transformer\AbstractResponseDtoTransformer;

class ResponseTestDemoDto extends AbstractResponseDtoTransformer
{
    public string $createTime;
}
