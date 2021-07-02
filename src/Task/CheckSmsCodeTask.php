<?php
declare(strict_types=1);

namespace App\Task;

use App\Entity\Cache\SmsCodeCache;
use App\Exceptions\ValidatorInvalidParamsException;
use App\Utils\RedisUtils;
use ReflectionException;

class CheckSmsCodeTask
{
    private RedisUtils $redisUtils;

    /**
     * CheckSmsCodeTask constructor.
     * @param RedisUtils $redisUtils
     */
    public function __construct(RedisUtils $redisUtils)
    {
        $this->redisUtils = $redisUtils;
    }

    /**
     * @param string $phone
     * @param string $code
     * @throws ReflectionException
     */
    public function run(string $phone, string $code)
    {
        //检查手机验证码是否正确
        /**@var SmsCodeCache $codeCache */
        $codeCache = $this->redisUtils->getCacheQuery(SmsCodeCache::class)->getObject($phone);
        if (is_null($codeCache) || $codeCache->code !== $code) {
            throw new ValidatorInvalidParamsException('手机验证码错误');
        }
        $this->redisUtils->delObject($codeCache);
    }
}
