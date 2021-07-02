<?php
declare(strict_types=1);

namespace App\Action;

use App\Dto\Request\CommonQueryDto;
use App\Entity\User;
use App\Repository\ScoreBillRepository;
use Symfony\Component\Security\Core\Security;

class QueryScoreLogAction
{
    private ScoreBillRepository $scoreBillRepository;

    private Security $security;

    /**
     * QueryScoreLogAction constructor.
     * @param ScoreBillRepository $scoreBillRepository
     * @param Security $security
     */
    public function __construct(ScoreBillRepository $scoreBillRepository, Security $security)
    {
        $this->scoreBillRepository = $scoreBillRepository;
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
        return $this->scoreBillRepository->queryUserScoreLog($dto, $u);
    }
}
