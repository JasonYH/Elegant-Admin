<?php
declare(strict_types=1);

namespace App\Security\Provider;

use App\Entity\User;
use App\Exceptions\UnauthorizedException;
use App\Repository\UserRepository;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class TokenUserProvider implements UserProviderInterface, PasswordUpgraderInterface
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * 升级用户的编码密码，通常是为了使用更好的哈希算法。
     * @param UserInterface $user
     * @param string $newEncodedPassword
     */
    public function upgradePassword(UserInterface $user, string $newEncodedPassword): void
    {
        // 使用编码密码时，此方法应：
        // 1.将新密码保留在用户存储中；
        // 2.使用user-> setPassword（newEncodedPassword）更新用户对象；
    }

    /**
     * 如果您使用switch_user或Remember_me之类的功能，
     * Symfony会调用此方法。如果不使用这些功能，则无需实现此方法。
     *
     * @param string $username
     *
     * @return UserInterface
     *
     */
    public function loadUserByUsername(string $username): UserInterface
    {
        // 从数据源加载User对象或引发UsernameNotFoundException。
        // username参数实际上可能不是用户名：它是User类中的getUsername（）方法返回的任何值。
        $user = $this->userRepository->findByIdField($username);
        if (!$user) {
            throw new UnauthorizedException();
        }
        return $user;
    }

    /**
     * 从会话中重新加载后，刷新用户。
     * 当用户登录时，在每个请求的开始时，将从会话中加载User对象，然后调用此方法。
     * 您的工作是通过例如重新查询新的用户数据来确保用户的数据仍然是最新的。
     * 如果您的防火墙是“stateless：true”（对于纯API），则不会调用此方法。
     *
     * @param UserInterface $user
     *
     * @return UserInterface
     *
     * @throws UsernameNotFoundException if the user is not found
     */
    public function refreshUser(UserInterface $user): UserInterface
    {
        return $user;
    }

    /**
     * 告诉Symfony为此用户类使用此提供程序。
     * @param string $class
     * @return bool
     */
    public function supportsClass(string $class): bool
    {
        return User::class === $class || is_subclass_of($class, User::class);
    }
}
