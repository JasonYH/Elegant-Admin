<?php
declare(strict_types=1);

namespace App\Dto\Response;

use App\Dto\Response\Transformer\AbstractResponseDtoTransformer;

class BulletinResponseDto extends AbstractResponseDtoTransformer
{
    public string $title;

    public string $content;

    public string $createTime;
}
