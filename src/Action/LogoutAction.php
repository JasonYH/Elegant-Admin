<?php
declare(strict_types=1);

namespace App\Action;

use App\Entity\User;
use App\Task\UpdateUserInfoCacheTask;
use ReflectionException;

class LogoutAction
{
    private UpdateUserInfoCacheTask $updateUserInfoCacheTask;

    /**
     * LogoutAction constructor.
     * @param UpdateUserInfoCacheTask $updateUserInfoCacheTask
     */
    public function __construct(UpdateUserInfoCacheTask $updateUserInfoCacheTask)
    {
        $this->updateUserInfoCacheTask = $updateUserInfoCacheTask;
    }

    /**
     * @param User $user
     * @param string $token
     * @return bool
     * @throws ReflectionException
     */
    public function run(User $user, string $token): bool
    {
        return $this->updateUserInfoCacheTask->run($user, $token, true);
    }
}
