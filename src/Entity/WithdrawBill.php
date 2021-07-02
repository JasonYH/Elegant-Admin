<?php

namespace App\Entity;

use App\Repository\WithdrawBillRepository;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass=WithdrawBillRepository::class)
 * @ORM\Table(
 *     options={"comment"="提现记录表"},
 *     indexes={
 *          @ORM\Index(name="userid_idx",columns={"user_id"}),
 *     })
 * @Gedmo\SoftDeleteable(fieldName="deletedTime")
 */
class WithdrawBill
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="bigint")
     */
    private ?string $id;

    /**
     * @ORM\Column(type="bigint",options={"comment"="用户id"})
     */
    private ?string $userId;

    /**
     * @ORM\Column(type="decimal",length=10,scale=2,options={"comment"="提现额度"})
     */
    private ?string $amount;

    /**
     * @ORM\Column(type="string",options={"comment"="收款账号"})
     */
    private ?string $accountNumber;

    /**
     * @ORM\Column(type="string",options={"comment"="收款人姓名"})
     */
    private ?string $accountName;

    /**
     * @ORM\Column(type="integer",length=2,options={"comment"="收款方式[1-支付宝，2-微信，3-银行卡]"})
     */
    private ?int $type;

    /**
     * @ORM\Column(type="integer",length=2,options={"comment"="结算状态[1-审核中，2-已结算，3-已拒绝]"})
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

    public function getAccountNumber(): ?string
    {
        return $this->accountNumber;
    }

    public function setAccountNumber(string $accountNumber): self
    {
        $this->accountNumber = $accountNumber;

        return $this;
    }

    public function getAccountName(): ?string
    {
        return $this->accountName;
    }

    public function setAccountName(string $accountName): self
    {
        $this->accountName = $accountName;

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

    /**
     * @return int|null
     */
    public function getStatus(): ?int
    {
        return $this->status;
    }

    /**
     * @param int|null $status
     * @return WithdrawBill
     */
    public function setStatus(?int $status): self
    {
        $this->status = $status;
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
