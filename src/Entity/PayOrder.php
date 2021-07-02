<?php

namespace App\Entity;

use App\Repository\PayOrderRepository;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass=PayOrderRepository::class)
 * @ORM\Table(
 *     options={"comment"="充值订单表"},
 *     indexes={
 *          @ORM\Index(name="userid_idx",columns={"user_id"}),
 *          @ORM\Index(name="parentid_idx",columns={"parent_id"}),
 *          @ORM\Index(name="status_idx",columns={"status"}),
 *          @ORM\Index(name="createtime_idx",columns={"created_time"})
 *     })
 * @Gedmo\SoftDeleteable(fieldName="deletedTime")
 */
class PayOrder
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="bigint")
     */
    private ?string $id;

    /**
     * @ORM\Column(type="string", unique=true, length=255,options={"comment"="订单id"})
     */
    private ?string $orderId;

    /**
     * @ORM\Column(type="bigint",options={"comment"="用户id"})
     */
    private ?string $userId;

    /**
     * @ORM\Column(type="bigint",options={"comment"="上级抽佣金人id"})
     */
    private ?string $parentId;

    /**
     * @ORM\Column(type="integer",options={"comment"="此单抽佣比例"})
     */
    private ?int $payRakeProportion;

    /**
     * @ORM\Column(type="decimal",length=10,scale=2,options={"comment"="此单抽佣总额"})
     */
    private ?string $payRakeTotal;

    /**
     * @ORM\Column(type="integer",options={"comment"="此单积分充值比例"})
     */
    private ?int $scorePayProportion;

    /**
     * @ORM\Column(type="decimal",length=10,scale=2,options={"comment"="此单充值总积分"})
     */
    private ?string $scoreTotal;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2,options={"comment"="充值金额"})
     */
    private ?string $amount;

    /**
     * @ORM\Column(type="string",options={"comment"="第三方平台支付流水号"})
     */
    private ?string $serialId;

    /**
     * @ORM\Column(type="integer",options={"comment"="支付方式【1支付宝，2微信】"})
     */
    private ?int $payType;

    /**
     * @ORM\Column(type="integer",options={"comment"="订单状态【1待支付，2已支付，3失效】"})
     */
    private ?int $status;

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

    public function getOrderId(): ?string
    {
        return $this->orderId;
    }

    public function setOrderId(string $orderId): self
    {
        $this->orderId = $orderId;

        return $this;
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

    public function getParentId(): ?string
    {
        return $this->parentId;
    }

    public function setParentId(string $parentId): self
    {
        $this->parentId = $parentId;

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

    public function getScorePayProportion(): ?int
    {
        return $this->scorePayProportion;
    }

    public function setScorePayProportion(int $scorePayProportion): self
    {
        $this->scorePayProportion = $scorePayProportion;

        return $this;
    }

    public function getScoreTotal(): ?string
    {
        return $this->scoreTotal;
    }

    public function setScoreTotal(string $scoreTotal): self
    {
        $this->scoreTotal = $scoreTotal;

        return $this;
    }

    public function getAmount(): ?string
    {
        return $this->amount;
    }

    public function setAmount(string $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getSerialId(): ?string
    {
        return $this->serialId;
    }

    public function setSerialId(string $serialId): self
    {
        $this->serialId = $serialId;

        return $this;
    }

    public function getPayType(): ?int
    {
        return $this->payType;
    }

    public function setPayType(int $payType): self
    {
        $this->payType = $payType;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getCreatedTime(): ?\DateTimeInterface
    {
        return $this->createdTime;
    }

    public function setCreatedTime(?\DateTimeInterface $createdTime): self
    {
        $this->createdTime = $createdTime;

        return $this;
    }

    public function getUpdatedTime(): ?\DateTimeInterface
    {
        return $this->updatedTime;
    }

    public function setUpdatedTime(?\DateTimeInterface $updatedTime): self
    {
        $this->updatedTime = $updatedTime;

        return $this;
    }

    public function getDeletedTime(): ?\DateTimeInterface
    {
        return $this->deletedTime;
    }

    public function setDeletedTime(?\DateTimeInterface $deletedTime): self
    {
        $this->deletedTime = $deletedTime;

        return $this;
    }
}
