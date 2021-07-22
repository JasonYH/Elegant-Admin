<?php
declare(strict_types=1);

namespace App\Security;

use App\Entity\Cache\UserCache;
use App\Repository\UserRepository;
use Symfony\Component\Security\Core\User\UserInterface;

class ApiUserProvider implements UserInterface
{
    private UserCache $userCache;

    private UserRepository $userRepository;

    /**
     * ApiUserProvider constructor.
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param UserCache $userCache
     * @return ApiUserProvider
     */
    public function setUserCache(UserCache $userCache): self
    {
        $this->userCache = $userCache;
        return $this;
    }

    public function getUserEntity()
    {
        return $this->userRepository->findByIdField($this->userCache->id);
    }

    public function getRoles(): array
    {
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function getPassword()
    {
        return null;
    }

    public function getSalt()
    {
        return null;
    }

    public function eraseCredentials()
    {
    }

    public function getUsername(): string
    {
        return $this->userCache->username;
    }

    public function getUserIdentifier(): string
    {
        return $this->userCache->id;
    }
}
