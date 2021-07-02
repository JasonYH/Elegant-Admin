<?php
declare(strict_types=1);

namespace App\Action;

use App\Repository\CommonProblemRepository;

class GetAllCommonProblemAction
{
    private CommonProblemRepository $commonProblemRepository;

    public function __construct(CommonProblemRepository $commonProblemRepository)
    {
        $this->commonProblemRepository = $commonProblemRepository;
    }

    public function run(): array
    {
        return $this->commonProblemRepository->findAll();
    }
}
