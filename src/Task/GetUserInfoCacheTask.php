<?php
declare(strict_types=1);

namespace App\Task;

use App\Entity\Cache\UserCache;
use App\Utils\RedisUtils;
use ReflectionException;

class GetUserInfoCacheTask
{
    private RedisUtils $redisUtils;

    /**
     * GetUserInfoCacheTask constructor.
     * @param RedisUtils $redisUtils
     */
    public function __construct(RedisUtils $redisUtils)
    {
        $this->redisUtils = $redisUtils;
    }

    /**
     * @param string $userId
     * @return UserCache|null
     * @throws ReflectionException
     */
    public function run(string $userId): ?UserCache
    {
        /**
         * @var UserCache $userCache
         */
        $userCache = $this->redisUtils->getCacheQuery(UserCache::class)->getObject($userId);

        return $userCache;
    }
}
