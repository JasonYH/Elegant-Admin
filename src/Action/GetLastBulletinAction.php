<?php
declare(strict_types=1);

namespace App\Action;

use App\Entity\Bulletin;
use App\Repository\BulletinRepository;

class GetLastBulletinAction
{
    private BulletinRepository $bulletinRepository;

    public function __construct(BulletinRepository $bulletinRepository)
    {
        $this->bulletinRepository = $bulletinRepository;
    }

    public function run(): ?Bulletin
    {
        return $this->bulletinRepository->findLastOne();

    }
}
