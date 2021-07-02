<?php
declare(strict_types=1);

namespace App\Action;

use App\Dto\Request\LoginDto;
use App\Exceptions\NotFoundException;
use App\Exceptions\ValidatorInvalidParamsException;
use App\Repository\UserRepository;
use App\Task\UpdateUserInfoCacheTask;
use App\Utils\TokenUtils\TokenUtils;
use Doctrine\ORM\EntityManagerInterface;
use ReflectionException;

class LoginAction
{
    private UserRepository $userRespository;

    private EntityManagerInterface $entityManager;

    private UpdateUserInfoCacheTask $updateUserInfoCacheTask;

    private TokenUtils $tokenUtils;

    /**
     * LoginAction constructor.
     * @param UserRepository $userRespository
     * @param EntityManagerInterface $entityManager
     * @param UpdateUserInfoCacheTask $updateUserInfoCacheTask
     * @param TokenUtils $tokenUtils
     */
    public function __construct(
        UserRepository $userRespository,
        EntityManagerInterface $entityManager,
        UpdateUserInfoCacheTask $updateUserInfoCacheTask,
        TokenUtils $tokenUtils
    ) {
        $this->userRespository = $userRespository;
        $this->entityManager = $entityManager;
        $this->updateUserInfoCacheTask = $updateUserInfoCacheTask;
        $this->tokenUtils = $tokenUtils;
    }

    /**
     * 登陆操作
     * @param LoginDto $loginDto
     * @return array
     * @throws ReflectionException
     */
    public function run(LoginDto $loginDto): array
    {
        $user = $this->userRespository->findByPhoneField($loginDto->phone);

        if (is_null($user)) {
            throw new NotFoundException('账号不存在');
        }
        if ($user->getPassword() !== hash_hmac('sha256', $loginDto->password, '')) {
            throw new ValidatorInvalidParamsException('密码错误');
        }
        if ($user->getStatus() !== 1) {
            throw new ValidatorInvalidParamsException('账号异常');
        }

        // 生成token
        if ($loginDto->remeber) {
            $token = $this->tokenUtils->generateToken($user->getId(), '+7 day');
        } else {
            $token = $this->tokenUtils->generateToken($user->getId());
        }

        // 更新缓存
        $this->updateUserInfoCacheTask->run($user, $token);

        return ['userInfo' => $user, 'token' => $token];
    }
}
