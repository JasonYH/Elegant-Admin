<?php
declare(strict_types=1);

namespace App\Dto\Response;

use App\Dto\Response\Transformer\AbstractResponseDtoTransformer;

class CustomerServiceInfoResponseDto extends AbstractResponseDtoTransformer
{
    public string $wechat;

    public string $qq;

    public string $wechatQrc;
}
