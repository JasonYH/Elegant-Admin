<?php
declare(strict_types=1);

namespace App\Action;

use App\Dto\Request\CommonQueryDto;
use App\Entity\User;
use App\Repository\PayOrderRepository;
use Symfony\Component\Security\Core\Security;

class QueryPayLogAction
{
    private PayOrderRepository $payOrderRepository;

    private Security $security;

    public function __construct(PayOrderRepository $payOrderRepository, Security $security)
    {
        $this->payOrderRepository = $payOrderRepository;
        $this->security = $security;
    }

    /**
     * @param CommonQueryDto $dto
     * @return array
     */
    public function run(CommonQueryDto $dto): array
    {
        /**@var User $u */
        $u = $this->security->getUser();
        return $this->payOrderRepository->queryUserPayLog($dto, $u);
    }
}
