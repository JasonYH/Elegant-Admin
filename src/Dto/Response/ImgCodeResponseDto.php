<?php
declare(strict_types=1);

namespace App\Dto\Response;



use App\Dto\Response\Transformer\AbstractResponseDtoTransformer;

class ImgCodeResponseDto extends AbstractResponseDtoTransformer
{
    public string $key;

    public string $imgData;
}
