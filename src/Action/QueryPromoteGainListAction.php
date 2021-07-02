<?php
declare(strict_types=1);

namespace App\Action;

use App\Dto\Request\CommonQueryDto;
use App\Entity\User;
use App\Repository\PromoteGainRepository;
use Symfony\Component\Security\Core\Security;

class QueryPromoteGainListAction
{

    private Security $security;

    private PromoteGainRepository $promoteGainRepository;

    public function __construct(Security $security, PromoteGainRepository $promoteGainRepository)
    {
        $this->security = $security;
        $this->promoteGainRepository = $promoteGainRepository;
    }

    public function run(CommonQueryDto $dto): array
    {
        /**@var User $u */
        $u = $this->security->getUser();
        return $this->promoteGainRepository->queryPromoteGainList($dto, $u);
    }
}
