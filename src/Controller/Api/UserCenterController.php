<?php
declare(strict_types=1);

namespace App\Controller\Api;

use App\Dto\Response\UserInfoResponseDto;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class UserCenterController
 * @package App\Controller\Api
 *
 * @Route("/api")
 */
class UserCenterController extends AbstractController
{
    /**
     * @Route("/get-user-info",methods={"GET"})
     * @return Response
     */
    public function getUserInfo(): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        $response = new UserInfoResponseDto();

        $response->phone = $user->getPhone() ?? '';
        $response->promotionCode = $user->getPromotionCode() ?? '';
        $response->id = $user->getId() ?? '';
        $response->identity = $user->getIdentity() ?? 0;
        $response->parent_id = $user->getParentId() ?? '';
        $response->promotionPeople = $user->getPromotionPeople() ?? 0;
        $response->promotionRevenue = $user->getPromotionRevenue() ?? '';
        $response->score = $user->getScore() ?? '';

        return $response->transformerResponse();
    }
}
