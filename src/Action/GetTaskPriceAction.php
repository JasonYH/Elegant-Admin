<?php
declare(strict_types=1);

namespace App\Action;

use App\Repository\TaskPriceRepository;

class GetTaskPriceAction
{
    private TaskPriceRepository $taskPriceRepository;

    public function __construct(TaskPriceRepository $taskPriceRepository)
    {
        $this->taskPriceRepository = $taskPriceRepository;
    }

    public function run(): array
    {
        return $this->taskPriceRepository->findAll();
    }
}
