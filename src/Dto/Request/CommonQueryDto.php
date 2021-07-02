<?php
declare(strict_types=1);

namespace App\Dto\Request;

use App\Dto\Request\Transformer\AbstractRequestDtoTransformer;

class CommonQueryDto extends AbstractRequestDtoTransformer
{
    public int $type = 0;

    public int $page = 1;

    public int $pageCount = 10;

    public string $searchKey = '';

    public string $strDate = '';

    public string $endDate = '';
}
