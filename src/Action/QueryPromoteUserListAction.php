<?php
declare(strict_types=1);

namespace App\Action;

use App\Dto\Request\CommonQueryDto;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\Security\Core\Security;

class QueryPromoteUserListAction
{
    private UserRepository $userRepository;

    private Security $security;

    /**
     * QueryPromoteUserListAction constructor.
     * @param UserRepository $userRepository
     * @param Security $security
     */
    public function __construct(UserRepository $userRepository, Security $security)
    {
        $this->userRepository = $userRepository;
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
        return $this->userRepository->queryPromoteUser($dto, $u);
    }
}
