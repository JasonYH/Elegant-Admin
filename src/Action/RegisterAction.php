<?php
declare(strict_types=1);

namespace App\Action;

use App\Dto\Request\RegisterDto;
use App\Entity\User;
use App\Exceptions\ValidatorInvalidParamsException;
use App\Repository\UserRepository;
use App\Task\CheckSmsCodeTask;
use App\Utils\InvitaionCode;
use App\Utils\RedisUtils;
use Doctrine\Persistence\ManagerRegistry;
use ReflectionException;

class RegisterAction
{
    private RedisUtils $redisUtils;

    private UserRepository $userRepository;

    private ManagerRegistry $managerRegister;

    private InvitaionCode $invitaionCode;

    private CheckSmsCodeTask $checkSmsCodeTask;

    /**
     * RegisterAction constructor.
     * @param RedisUtils $redisUtils
     * @param UserRepository $userRepository
     * @param ManagerRegistry $managerRegister
     * @param InvitaionCode $invitaionCode
     * @param CheckSmsCodeTask $checkSmsCodeTask
     */
    public function __construct(
        RedisUtils $redisUtils,
        UserRepository $userRepository,
        ManagerRegistry $managerRegister,
        InvitaionCode $invitaionCode,
        CheckSmsCodeTask $checkSmsCodeTask
    ) {
        $this->redisUtils = $redisUtils;
        $this->userRepository = $userRepository;
        $this->managerRegister = $managerRegister;
        $this->invitaionCode = $invitaionCode;
        $this->checkSmsCodeTask = $checkSmsCodeTask;
    }

    /**
     * @param RegisterDto $dto
     * @throws ReflectionException
     */
    public function run(RegisterDto $dto)
    {
        //检查手机验证码是否正确
        $this->checkSmsCodeTask->run($dto->phone, $dto->code);
        //检查账号是否存在
        $user = $this->userRepository->findByPhoneField($dto->phone);
        if ($user) {
            throw new ValidatorInvalidParamsException('账号已存在');
        }

        //检查推广码
        $parentId = '1';
        if (!empty($dto->promotionCode)) {
            $parent = $this->userRepository->findByPromotionCodeProField($dto->promotionCode);
            if ($parent) {
                $parentId = $parent->getId();
            }
        }

        //保存账号
        $user = new User();
        $user->setPhone($dto->phone);
        $user->setPassword(hash_hmac('sha256', $dto->password, ''));
        $user->setParentId($parentId);
        $user->setPromotionCode('');

        $manager = $this->managerRegister->getManager();
        $manager->persist($user);
        $manager->flush();

        //生成推广码
        $user->setPromotionCode($this->invitaionCode->encode($user->getId()));
        //更新上级推广人数
        $this->userRepository->incrementPromotionPeople($user->getParentId());
        $manager->flush();
    }
}
