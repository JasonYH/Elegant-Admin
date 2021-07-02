<?php
declare(strict_types=1);

namespace App\Action;

use App\Repository\SystemConfigRepository;

class GetSystemConfigAction
{
    private SystemConfigRepository $systemConfigRepository;

    public function __construct(SystemConfigRepository $systemConfigRepository)
    {
        $this->systemConfigRepository = $systemConfigRepository;
    }

    public function run(...$key): array
    {
        return $this->systemConfigRepository->getValueByKey(...$key);
    }
}
