<?php

namespace App\Entity;

use App\Repository\PromoteGainRepository;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass=PromoteGainRepository::class)
 * @ORM\Table(
 *     options={"comment"="推广收益表"},
 *     indexes={
 *          @ORM\Index(name="userid_idx",columns={"user_id"}),
 *          @ORM\Index(name="orderid_idx",columns={"order_id"}),
 *     })
 * @Gedmo\SoftDeleteable(fieldName="deletedTime")
 */
class PromoteGain
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="bigint")
     */
    private ?string $id;

    /**
     * @ORM\Column(type="bigint",options={"comment"="返现记录人id"})
     */
    private ?string $userId;

    /**
     * @ORM\Column(type="string", options={"comment"="订单自定义id"})
     */
    private ?string $orderId;

    /**
     * @ORM\Column(type="string", options={"comment"="记录摘要"})
     */
    private ?string $summary;

    /**
     * @ORM\Column(type="integer",options={"comment"="此单当时抽佣比例"})
     */
    private ?int $payRakeProportion;

    /**
     * @ORM\Column(type="decimal",length=10,scale=2,options={"comment"="此单抽佣总额"})
     */
    private ?string $payRakeTotal;

    /**
     * @ORM\Column(type="decimal",length=10,scale=2,options={"comment"="剩余可提现额度"})
     */
    private ?string $balance;

    /**
     * @ORM\Column(type="integer",length=10,scale=2,options={"comment"="记录类型【1-增加收益，2-提现收益】"})
     */
    private ?int $type;

    /**
     * @ORM\Column(type="datetime", nullable=true, options={"comment"="创建时间"})
     * @Gedmo\Timestampable(on ="create")
     */
    private ?DateTimeInterface $createdTime;

    /**
     * @ORM\Column(type="datetime", nullable=true, options={"comment"="更新时间"})
     * @Gedmo\Timestampable(on ="update")
     */
    private ?DateTimeInterface $updatedTime;

    /**
     * @ORM\Column(type="datetime", nullable=true, options={"comment"="删除时间"})
     */
    private ?DateTimeInterface $deletedTime;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getUserId(): ?string
    {
        return $this->userId;
    }

    public function setUserId(string $userId): self
    {
        $this->userId = $userId;

        return $this;
    }

    public function getOrderId(): ?string
    {
        return $this->orderId;
    }

    public function setOrderId(string $orderId): self
    {
        $this->orderId = $orderId;

        return $this;
    }

    public function getSummary(): ?string
    {
        return $this->summary;
    }

    public function setSummary(string $summary): self
    {
        $this->summary = $summary;

        return $this;
    }

    public function getPayRakeProportion(): ?int
    {
        return $this->payRakeProportion;
    }

    public function setPayRakeProportion(int $payRakeProportion): self
    {
        $this->payRakeProportion = $payRakeProportion;

        return $this;
    }

    public function getPayRakeTotal(): ?string
    {
        return $this->payRakeTotal;
    }

    public function setPayRakeTotal(string $payRakeTotal): self
    {
        $this->payRakeTotal = $payRakeTotal;

        return $this;
    }

    public function getBalance(): ?string
    {
        return $this->balance;
    }

    public function setBalance(string $balance): self
    {
        $this->balance = $balance;

        return $this;
    }

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(int $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getCreatedTime(): ?DateTimeInterface
    {
        return $this->createdTime;
    }

    public function setCreatedTime(?DateTimeInterface $createdTime): self
    {
        $this->createdTime = $createdTime;

        return $this;
    }

    public function getUpdatedTime(): ?DateTimeInterface
    {
        return $this->updatedTime;
    }

    public function setUpdatedTime(?DateTimeInterface $updatedTime): self
    {
        $this->updatedTime = $updatedTime;

        return $this;
    }

    public function getDeletedTime(): ?DateTimeInterface
    {
        return $this->deletedTime;
    }

    public function setDeletedTime(?DateTimeInterface $deletedTime): self
    {
        $this->deletedTime = $deletedTime;

        return $this;
    }
}
