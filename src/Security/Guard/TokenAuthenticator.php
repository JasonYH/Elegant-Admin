<?php
declare(strict_types=1);

namespace App\Security\Guard;

use App\Exceptions\NoPermissionException;
use App\Exceptions\UnauthorizedException;
use App\Task\GetUserInfoCacheTask;
use App\Utils\TokenUtils\TokenDto;
use App\Utils\TokenUtils\TokenUtils;
use ReflectionException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;

class TokenAuthenticator extends AbstractGuardAuthenticator
{
    private TokenUtils $tokenUtils;

    private GetUserInfoCacheTask $getUserInfoCacheTask;

    /**
     * TokenAuthenticator constructor.
     * @param TokenUtils $tokenUtils
     * @param GetUserInfoCacheTask $getUserInfoCacheTask
     */
    public function __construct(TokenUtils $tokenUtils, GetUserInfoCacheTask $getUserInfoCacheTask)
    {
        $this->tokenUtils = $tokenUtils;
        $this->getUserInfoCacheTask = $getUserInfoCacheTask;
    }

    /**
     * 验证者是否支持给定的请求？如果返回false，则将跳过身份验证器。
     *
     * @param Request $request
     * @return bool
     */
    public function supports(Request $request): bool
    {
        return true;
    }

    /**
     * 从请求中获取身份验证凭据，
     * 并将其作为任何类型返回（例如，关联数组）。
     * 无论您在此处返回什么值，都将传递给 getUser（）和checkCredentials（
     *
     * 例如API令牌，您可以使用：
     *
     *      return ['api_key' => $request->headers->get('X-API-TOKEN')];
     *
     * @param Request $request
     *
     * @return string
     *
     * @throws UnauthorizedException If null is returned
     */
    public function getCredentials(Request $request): string
    {
        $token = $request->headers->get('API-TOKEN');
        if (!$token) {
            throw new UnauthorizedException();
        }
        return $token;
    }

    /**
     * 根据getCredentials()方法获得到的凭据返回 UserInterface 对象。
     * 如果需要，可以抛出 AuthenticationException。
     * 如果返回null，则将抛出 UsernameNotFoundException。
     * @param $credentials
     * @param UserProviderInterface $userProvider
     * @return UserInterface|null
     * @throws ReflectionException
     */
    public function getUser($credentials, UserProviderInterface $userProvider): ?UserInterface
    {
        /**
         * @var TokenDto $token
         */
        $token = $this->tokenUtils->validateToken($credentials);
        if (!$token) {
            throw new UnauthorizedException();
        }

        $userCache = $this->getUserInfoCacheTask->run($token->id);

        if (is_null($userCache) || !in_array($credentials, $userCache->tokens)) {
            throw new UnauthorizedException();
        }

        if ($userCache->status === 0) {
            throw new NoPermissionException('账号异常');
        }



        return $userProvider->loadUserByUsername($token->id);
    }

    /**
     * 如果凭据有效，则返回true。
     * 如果返回false，则身份验证将失败。
     * 如果您希望导致身份验证失败，也可以抛出AuthenticationException。
     * 凭证是getCredentials（）的返回值
     *
     * @param mixed $credentials
     * @param UserInterface $user
     *
     * @return bool
     *
     * @throws AuthenticationException
     */
    public function checkCredentials($credentials, UserInterface $user): bool
    {
        return true;
    }

    /**
     * 执行身份验证但失败时调用（例如，错误的用户名密码）。
     * 这应该将发送给用户的响应返回给用户，例如对登录页面的RedirectResponse或401响应。
     * 如果返回null，则请求将继续，但不会对用户进行身份验证。这可能不是您想要的。
     *
     * @param Request $request
     * @param AuthenticationException $exception
     * @return Response|null
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        return null;
    }

    /**
     * 执行身份验证并成功后调用！
     * 这应该将发送给用户的响应返回给用户，例如将RedirectResponse返回到他们访问的最后一页。
     * 如果返回null，则当前请求将继续，并且用户将通过身份验证。
     * 例如，这对于API来说是有意义的。
     *
     * @param Request $request
     * @param TokenInterface $token
     * @param string $providerKey
     * @return Response|null
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $providerKey): ?Response
    {
        return null;
    }

    /**
     * 此方法是否支持记住我的cookie？
     * 如果满足以下所有条件，将设置记住我的cookie：
     * A）此方法返回true
     * B）配置了防火墙下的Remember_me密钥
     * C）激活了“记住我”功能。
     *      通过在表单中具有_remember_me复选框来完成，但是
     *      可以通过“ always_remember_me”和“ remember_me_parameter”进行配置
     *      “ remember_me”防火墙密钥下的参数
     * D）onAuthenticationSuccess方法返回一个Response对象
     *
     * @return bool
     */
    public function supportsRememberMe(): bool
    {
        return false;
    }

    /**
     * 返回指示用户进行身份验证的响应。
     * 当匿名请求访问的资源
     * 需要认证。此方法的工作是返回一些
     * “帮助”用户的响应开始进入身份验证过程。
     *
     * Examples:
     *
     * - 对于表单登录，您可以重定向到登录页面
     *
     *     return new RedirectResponse('/login');
     *
     * - 对于API令牌认证系统，您将返回401响应
     *
     *     return new Response('Auth header required', 401);
     *
     * @param Request $request
     * @param AuthenticationException|null $authException
     * @return Response
     */
    public function start(Request $request, AuthenticationException $authException = null): Response
    {
        throw new UnauthorizedException();
    }
}
