<?php
declare(strict_types=1);

namespace App\Dto\Response;

use App\Dto\Response\Transformer\AbstractResponseDtoTransformer;

class CommonProblemResponseDto extends AbstractResponseDtoTransformer
{
    public string $title;

    public string $content;
}
