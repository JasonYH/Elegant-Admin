<?php
declare(strict_types=1);

namespace App\Controller\Api;

use App\Action\LoginAction;
use App\Action\LogoutAction;
use App\Action\RegisterAction;
use App\Action\ResetPasswordAction;
use App\Dto\Request\LoginDto;
use App\Dto\Request\RegisterDto;
use App\Dto\Request\ResetPassword;
use App\Dto\Response\LoginResponseDto;
use App\Dto\Response\SuccessResponseDto;
use App\Entity\User;
use ReflectionException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * 授权认证控制器
 * @package App\Controller\Api
 *
 * @Route("/api",defaults={"anonymous":true})
 */
class AuthorizeController extends AbstractController
{
    /**
     * 注册
     *
     * @Route("/register",methods={"POST"})
     *
     * @param RegisterDto $dto
     * @param RegisterAction $action
     * @param SuccessResponseDto $successResponseDto
     * @return Response
     * @throws ReflectionException
     */
    public function register(RegisterDto $dto, RegisterAction $action,SuccessResponseDto $successResponseDto): Response
    {
        $action->run($dto);
        return $successResponseDto->transformerResponse();
    }

    /**
     * 登陆
     *
     * @Route("/login",methods={"POST"})
     *
     * @param LoginDto $dto
     * @param LoginAction $action
     * @return Response
     * @throws ReflectionException
     */
    public function login(
        LoginDto $dto,
        LoginAction $action
    ): Response {
        /**
         * @var User $user
         */
        ['userInfo' => $user, 'token' => $token] = $action->run($dto);

        $response = new LoginResponseDto();
        $response->token = $token;
        $response->phone = $user->getPhone() ?? '';
        $response->promotionCode = $user->getPromotionCode() ?? '';
        $response->id = $user->getId() ?? '';
        $response->identity = $user->getIdentity() ?? 0;
        $response->parent_id = $user->getParentId() ?? '';
        $response->promotionPeople = $user->getPromotionPeople() ?? 0;
        $response->promotionRevenue = $user->getPromotionRevenue() ?? '';
        $response->score = $user->getScore() ?? '';
        $response->loginTime = date('Y-m-d H:i:s',time());

        return $response->transformerResponse();
    }

    /**
     * 登出
     *
     * @Route("/logout",methods={"GET"},defaults={"anonymous":false})
     *
     * @param Request $request
     * @param LogoutAction $action
     * @param SuccessResponseDto $successResponseDto
     * @return Response
     * @throws ReflectionException
     */
    public function logout(Request $request, LogoutAction $action, SuccessResponseDto $successResponseDto): Response
    {
        $token = $request->headers->get('API-TOKEN');
        /**@var User $user */
        $user = $this->getUser();
        $action->run($user, $token);
        return $successResponseDto->transformerResponse();
    }

    /**
     * 重置密码
     *
     * @Route("/reset-pwd",methods={"POST"})
     *
     * @param ResetPassword $dto
     * @param ResetPasswordAction $action
     * @param SuccessResponseDto $successResponseDto
     * @return Response
     * @throws ReflectionException
     */
    public function resetPassword(
        ResetPassword $dto,
        ResetPasswordAction $action,
        SuccessResponseDto $successResponseDto
    ): Response {
        $action->run($dto);
        return $successResponseDto->transformerResponse();
    }
}
