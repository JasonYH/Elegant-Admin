<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\LockMode;
use Doctrine\Persistence\ManagerRegistry;
use Exception;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * @param $value
     * @return User|null
     */
    public function findByPhoneField($value): ?User
    {
        return $this->findOneBy(['phone' => $value]);
    }

    public function findByPromotionCodeProField($value): ?User
    {
        return  $this->findOneBy(['promotionCode' => $value]);
    }

    public function incrementPromotionPeople(string $userid)
    {
        $this->_em->getConnection()->beginTransaction();
        try {
            $user = $this->find($userid, LockMode::PESSIMISTIC_WRITE);
            $user->setPromotionPeople($user->getPromotionPeople() + 1);
            $this->_em->persist($user);
            $this->_em->flush();
            $this->_em->getConnection()->commit();
        }catch (Exception $ex){
            $this->_em->getConnection()->rollBack();
        }

    }

    /**
     * @param $value
     * @return User|null
     */
    public function findByIdField($value): ?User
    {
        return $this->findOneBy(['id' => $value]);
    }
}
