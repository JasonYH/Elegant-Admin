<?php
declare(strict_types=1);

namespace App\Action;

use App\Repository\PayConfigRepository;

class GetPayOptionsConfigAction
{
    private PayConfigRepository $payConfigRepository;

    public function __construct(PayConfigRepository $payConfigRepository)
    {
        $this->payConfigRepository = $payConfigRepository;
    }

    public function run(): array
    {
        return $this->payConfigRepository->findAll();
    }
}
