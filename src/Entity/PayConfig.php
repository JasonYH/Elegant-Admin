<?php

namespace App\Entity;

use App\Repository\PayConfigRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PayConfigRepository::class)
 * @ORM\Table(options={"comment"="充值选项表"})
 */
class PayConfig
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\Column(type="integer",options={"comment"="充值金额"})
     */
    private ?int $amount;

    /**
     * @ORM\Column(type="integer",options={"comment"="赠送身份"})
     */
    private ?int $identity;

    /**
     * @ORM\Column(type="integer",options={"comment"="赠送积分"})
     */
    private ?int $freeScore;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAmount(): ?int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getIdentity(): ?int
    {
        return $this->identity;
    }

    public function setIdentity(int $identity): self
    {
        $this->identity = $identity;

        return $this;
    }

    public function getFreeScore(): ?int
    {
        return $this->freeScore;
    }

    public function setFreeScore(int $freeScore): self
    {
        $this->freeScore = $freeScore;

        return $this;
    }
}
