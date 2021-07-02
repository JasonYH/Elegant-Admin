<?php
declare(strict_types=1);

namespace App\Action;

use App\Dto\Request\CommonQueryDto;
use App\Entity\User;
use App\Repository\WithdrawBillRepository;
use Symfony\Component\Security\Core\Security;

class QueryWithdrawBillListAction
{
    public Security $security;

    public WithdrawBillRepository $withdrawBillRepository;

    /**
     * QueryWithdrawBillListAction constructor.
     * @param Security $security
     * @param WithdrawBillRepository $withdrawBillRepository
     */
    public function __construct(Security $security, WithdrawBillRepository $withdrawBillRepository)
    {
        $this->security = $security;
        $this->withdrawBillRepository = $withdrawBillRepository;
    }

    /**
     * @param CommonQueryDto $dto
     * @return array
     */
    public function run(CommonQueryDto $dto): array
    {
        /**@var User $u */
        $u = $this->security->getUser();
        return $this->withdrawBillRepository->queryWithdrawBill($dto, $u);
    }
}
