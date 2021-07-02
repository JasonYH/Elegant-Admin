<?php
declare(strict_types=1);

namespace App\Task;

use App\Entity\Cache\UserCache;
use App\Entity\User;
use App\Utils\RedisUtils;
use App\Utils\TokenUtils\TokenUtils;
use DateTime;
use ReflectionException;

class UpdateUserInfoCacheTask
{
    private RedisUtils $redisUtils;

    private TokenUtils $tokenUtils;

    /**
     * UpdateUserInfoCacheTask constructor.
     * @param RedisUtils $redisUtils
     * @param TokenUtils $tokenUtils
     */
    public function __construct(RedisUtils $redisUtils, TokenUtils $tokenUtils)
    {
        $this->redisUtils = $redisUtils;
        $this->tokenUtils = $tokenUtils;
    }

    /**
     * @param User $user
     * @param string $token //指定token
     * @param bool $isRmToken //true删除指定token，false新增指定token
     * @param bool $flushToken  //是否清空token
     * @return bool
     * @throws ReflectionException
     */
    public function run(User $user, string $token = '', bool $isRmToken = false,$flushToken=false): bool
    {
        $minute = 60;
        $hours = 60 * $minute;
        $day = 24 * $hours;
//        生成用户缓存
        $cache = $this->redisUtils->getCacheQuery(UserCache::class)->getObject($user->getId());

        if (is_null($cache)) {
            $cache = new UserCache($user->getId());
            $cache->tokens=[];
        } else {
            if ($flushToken) {
                $cache->tokens = [];
            } else {
                foreach ($cache->tokens as $key => $item) {
                    // 检查失效token ，同时判断传入的token是否需要删除
                    if (!$this->tokenUtils->validateToken($item) || ($isRmToken && ($token === $item))) {
                        array_splice($cache->tokens, $key, 1);
                    }
                }
            }


        }

        if (!empty($token) && !$isRmToken && !$flushToken) {
            $cache->tokens[] = $token;
        }

        $cache->id = $user->getId() ?? '';
        $cache->parent_id = $user->getParentId() ?? '';
        $cache->status = $user->getStatus() ?? 0;
        $cache->phone = $user->getPhone() ?? '';
        $cache->score = $user->getScore() ?? '';
        $cache->identity = $user->getIdentity() ?? 0;
        $cache->promotionCode = $user->getPromotionCode() ?? '';
        $cache->promotionRevenue = $user->getPromotionRevenue() ?? '';
        $cache->promotionPeople = $user->getPromotionPeople() ?? 0;
        $cache->loginDate = new DateTime();

        return $this->redisUtils->setObject($cache, 30 * $day);
    }
}
