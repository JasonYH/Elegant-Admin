<?php

namespace App\Entity;

use App\Repository\TaskPriceRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TaskPriceRepository::class)
 * @ORM\Table(options={"comment"="任务价格表"})
 */
class TaskPrice
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\Column(type="string", length=50, options={"comment"="任务名称"})
     */
    private ?string $name;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, options={"comment"="vip1任务价格表"})
     */
    private ?string $vip1Price;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, options={"comment"="vip2任务价格表"})
     */
    private ?string $vip2Price;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, options={"comment"="vip3任务价格表"})
     */
    private ?string $vip3Price;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, options={"comment"="vip4任务价格表"})
     */
    private ?string $vip4Price;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, options={"comment"="vip5任务价格表"})
     */
    private ?string $vip5Price;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getVip1Price(): ?string
    {
        return $this->vip1Price;
    }

    public function setVip1Price(string $vip1Price): self
    {
        $this->vip1Price = $vip1Price;

        return $this;
    }

    public function getVip2Price(): ?string
    {
        return $this->vip2Price;
    }

    public function setVip2Price(string $vip2Price): self
    {
        $this->vip2Price = $vip2Price;

        return $this;
    }

    public function getVip3Price(): ?string
    {
        return $this->vip3Price;
    }

    public function setVip3Price(string $vip3Price): self
    {
        $this->vip3Price = $vip3Price;

        return $this;
    }

    public function getVip4Price(): ?string
    {
        return $this->vip4Price;
    }

    public function setVip4Price(string $vip4Price): self
    {
        $this->vip4Price = $vip4Price;

        return $this;
    }

    public function getVip5Price(): ?string
    {
        return $this->vip5Price;
    }

    public function setVip5Price(string $vip5Price): self
    {
        $this->vip5Price = $vip5Price;

        return $this;
    }


}
