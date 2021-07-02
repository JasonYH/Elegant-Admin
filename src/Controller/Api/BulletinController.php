<?php
declare(strict_types=1);

namespace App\Controller\Api;

use App\Action\GetLastBulletinAction;
use App\Dto\Response\BulletinResponseDto;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class BulletinController
 * @package App\Controller\Api
 *
 * @Route("/api")
 */
class BulletinController extends AbstractController
{
    /**
     * @Route("/get-last-bulletin",methods={"GET"})
     * @param GetLastBulletinAction $action
     * @param BulletinResponseDto $dto
     * @return Response
     */
    public function getLastBulletin(GetLastBulletinAction $action, BulletinResponseDto $dto): Response
    {
        $bulletin = $action->run();

        if ($bulletin) {
            $dto->title = $bulletin->getTitle() ?? '';
            $dto->content = $bulletin->getContent() ?? '';
            $dto->createTime = $bulletin->getCreatedTime()->format('Y-m-d') ?? '';
        }else{
            $dto->title = '暂无公告';
            $dto->content = '';
            $dto->createTime = '';
        }



        return $dto->transformerResponse();
    }
}
