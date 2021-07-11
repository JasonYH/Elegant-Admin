<?php

namespace App\Entity;

use App\Repository\UserRepository;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(
 *     options={"comment"="用户表"},
 *     indexes={
 *          @ORM\Index(name="parentid_idx",columns={"parent_id"})
 *     })
 * @Gedmo\SoftDeleteable(fieldName="deletedTime")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="bigint",options={"unsigned" = true})
     */
    private ?string $id;

    /**
     * @ORM\Column(type="bigint",options={"unsigned" = true,"comment"="上级id","default"=0})
     */
    private ?string $parentId = '0';

    /**
     * @ORM\Column(type="string", length=15,unique=true, options={"comment"="手机号"})
     */
    private ?string $phone;

    /**
     * @ORM\Column(type="string", length=80, options={"comment"="密码"})
     */
    private ?string $password;

    /**
     * @ORM\Column(type="decimal", length=10,scale=2, options={"comment"="可用积分"})
     */
    private ?string $score = '0';

    /**
     * @ORM\Column(type="decimal", length=10, scale=2, options={"comment"="累计充值总额"})
     */
    private ?string $payTotal = '0';

    /**
     * @ORM\Column(type="decimal", length=10, scale=2, options={"comment"="被抽佣金总计"})
     */
    private ?string $beBrokerageTotal = '0';

    /**
     * @ORM\Column(type="integer", length=1, options={"unsigned" = true, "comment"="用户身份【1普通会员，2金牌会员，3钻石会员，4超级会员，5代理会员】", "default"=1})
     */
    private ?int $identity = 1;

    /**
     * @ORM\Column(type="integer", length=1, options={"unsigned" = true, "comment"="用户状态【0冻结，1正常】", "default"=1})
     */
    private ?int $status = 1;

    /**
     * @ORM\Column(type="string", length=8, options={"comment"="推广码"})
     */
    private ?string $promotionCode;

    /**
     * @ORM\Column(type="decimal", length=10,scale=2, options={"comment"="推广余额"})
     */
    private ?string $promotionRevenue = '0';

    /**
     * @ORM\Column(type="integer",length=10, options={"unsigned" = true, "comment"="推广人数"})
     */
    private ?int $promotionPeople = 0;

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

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function getRoles(): array
    {
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function getSalt(): ?string
    {
        return null;
    }

    public function getUsername(): string
    {
        return (string)$this->phone;
    }

    /**
     * 从用户中删除敏感数据。
     *
     * 如果在任何给定时间点，敏感信息如
     * 纯文本密码存储在此对象上。
     */
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getParentId(): ?string
    {
        return $this->parentId;
    }

    public function setParentId(?string $parent_id): self
    {
        $this->parentId = $parent_id;
        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getScore(): ?string
    {
        return $this->score;
    }

    public function setScore(string $score): self
    {
        $this->score = $score;

        return $this;
    }

    public function getPayTotal(): ?string
    {
        return $this->payTotal;
    }

    public function setPayTotal(?string $payTotal): self
    {
        $this->payTotal = $payTotal;
        return $this;

    }

    public function getBeBrokerageTotal(): ?string
    {
        return $this->beBrokerageTotal;
    }

    public function setBeBrokerageTotal(?string $beBrokerageTotal): self
    {
        $this->beBrokerageTotal = $beBrokerageTotal;
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

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getPromotionCode(): ?string
    {
        return $this->promotionCode;
    }

    public function setPromotionCode(string $promotionCode): self
    {
        $this->promotionCode = $promotionCode;

        return $this;
    }

    public function getPromotionRevenue(): ?string
    {
        return $this->promotionRevenue;
    }

    public function setPromotionRevenue(string $promotionRevenue): self
    {
        $this->promotionRevenue = $promotionRevenue;

        return $this;
    }

    public function getPromotionPeople(): ?int
    {
        return $this->promotionPeople;
    }

    public function setPromotionPeople(int $promotionPeople): self
    {
        $this->promotionPeople = $promotionPeople;

        return $this;
    }

    public function getCreatedTime(): ?DateTimeInterface
    {
        return $this->createdTime;
    }

    public function setCreatedTime(DateTimeInterface $createdTime): self
    {
        $this->createdTime = $createdTime;

        return $this;
    }

    public function getUpdatedTime(): ?DateTimeInterface
    {
        return $this->updatedTime;
    }

    public function setUpdatedTime(DateTimeInterface $updatedTime): self
    {
        $this->updatedTime = $updatedTime;

        return $this;
    }

    public function getDeletedTime(): ?DateTimeInterface
    {
        return $this->deletedTime;
    }

    public function setDeletedTime(DateTimeInterface $deletedTime): self
    {
        $this->deletedTime = $deletedTime;

        return $this;
    }

    public function getUserIdentifier(): string
    {
        return $this->id;
    }
}
