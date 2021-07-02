<?php
declare(strict_types=1);

namespace App\Action;

use App\Dto\Request\ResetPassword;
use App\Exceptions\NotFoundException;
use App\Repository\UserRepository;
use App\Task\CheckSmsCodeTask;
use App\Task\UpdateUserInfoCacheTask;
use Doctrine\Persistence\ManagerRegistry;
use ReflectionException;

class ResetPasswordAction
{
    private CheckSmsCodeTask $checkSmsCodeTask;

    private ManagerRegistry $managerRegistry;

    private UpdateUserInfoCacheTask $updateUserInfoCacheTask;

    private UserRepository $userRepository;

    /**
     * ResetPasswordAction constructor.
     * @param CheckSmsCodeTask $checkSmsCodeTask
     * @param ManagerRegistry $managerRegistry
     * @param UpdateUserInfoCacheTask $updateUserInfoCacheTask
     * @param UserRepository $userRepository
     */
    public function __construct(
        CheckSmsCodeTask $checkSmsCodeTask,
        ManagerRegistry $managerRegistry,
        UpdateUserInfoCacheTask $updateUserInfoCacheTask,
        UserRepository $userRepository
    ) {
        $this->checkSmsCodeTask = $checkSmsCodeTask;
        $this->managerRegistry = $managerRegistry;
        $this->updateUserInfoCacheTask = $updateUserInfoCacheTask;
        $this->userRepository = $userRepository;
    }

    /**
     * @param ResetPassword $dto
     * @throws ReflectionException
     */
    public function run(ResetPassword $dto)
    {
        $this->checkSmsCodeTask->run($dto->phone, $dto->code);

        $user = $this->userRepository->findByPhoneField($dto->phone);
        if (!$user) {
            throw new NotFoundException('用户不存在');
        }

        $user->setPassword(hash_hmac('sha256', $dto->password, ''));
        $manager = $this->managerRegistry->getManager();
        $manager->persist($user);
        $manager->flush();

        $this->updateUserInfoCacheTask->run($user, '', false, true);
    }
}
