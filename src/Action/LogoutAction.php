<?php
declare(strict_types=1);

namespace App\Action;

use App\Security\ApiUserProvider;
use App\Task\UpdateUserInfoCacheTask;
use ReflectionException;

class LogoutAction
{
    private UpdateUserInfoCacheTask $updateUserInfoCacheTask;

    private ApiUserProvider $apiUserProvider;

    /**
     * @param UpdateUserInfoCacheTask $updateUserInfoCacheTask
     * @param ApiUserProvider $apiUserProvider
     */
    public function __construct(UpdateUserInfoCacheTask $updateUserInfoCacheTask, ApiUserProvider $apiUserProvider)
    {
        $this->updateUserInfoCacheTask = $updateUserInfoCacheTask;
        $this->apiUserProvider = $apiUserProvider;
    }

    /**
     * @param string $token
     * @return bool
     * @throws ReflectionException
     */
    public function run(string $token): bool
    {
        $user = $this->apiUserProvider->getUserEntity();
        return $this->updateUserInfoCacheTask->run($user, $token, true);
    }
}
