<?php

namespace App\Entity;

use App\Repository\ScoreBillRepository;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass=ScoreBillRepository::class)
 * @ORM\Table(
 *     options={"comment"="积分账单"},
 *     indexes={
 *          @ORM\Index(name="orderid_idx",columns={"order_id"}),
 *          @ORM\Index(name="userid_idx",columns={"user_id"}),
 *          @ORM\Index(name="type_idx",columns={"bill_type"}),
 *          @ORM\Index(name="createtime_idx",columns={"created_time"})
 *     })
 * @Gedmo\SoftDeleteable(fieldName="deletedTime")
 */
class ScoreBill
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="bigint")
     */
    private ?string $id;

    /**
     * @ORM\Column(type="string", options={"comment"="订单自定义id"})
     */
    private ?string $orderId;

    /**
     * @ORM\Column(type="bigint",options={"comment"="用户id"})
     */
    private ?string $userId;

    /**
     * @ORM\Column(type="decimal",length=10,scale=2,options={"comment"="消费额度"})
     */
    private ?string $amount;

    /**
     * @ORM\Column(type="decimal",length=10,scale=2,options={"comment"="剩余积分"})
     */
    private ?string $scoreBalance;

    /**
     * @ORM\Column(type="integer",length=2,options={"comment"="账单类型[1-充值，2-任务消耗，3-任务退还，4-管理员赠送，5-管理员清除]"})
     */
    private ?int $billType;

    /**
     * @ORM\Column(type="string",options={"comment"="备注"})
     */
    private ?string $remarks;

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

    public function getAmount(): ?string
    {
        return $this->amount;
    }

    public function setAmount(string $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getScoreBalance(): ?string
    {
        return $this->scoreBalance;
    }

    public function setScoreBalance(string $scoreBalance): self
    {
        $this->scoreBalance = $scoreBalance;

        return $this;
    }

    public function getBillType(): ?int
    {
        return $this->billType;
    }

    public function setBillType(int $billType): self
    {
        $this->billType = $billType;

        return $this;
    }

    public function getRemarks(): ?string
    {
        return $this->remarks;
    }

    public function setRemarks(string $remarks): self
    {
        $this->remarks = $remarks;

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
