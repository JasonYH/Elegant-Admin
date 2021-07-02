<?php

namespace App\Entity;

use App\Repository\SystemConfigRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SystemConfigRepository::class)
 * @ORM\Table(options={"comment"="系统配置表"},indexes={@ORM\Index(name="type_idx",columns={"type"})})
 */
class SystemConfig
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\Column(type="string", length=64, unique=true,options={"comment"="配置键"})
     */
    private ?string $config_key;

    /**
     * @ORM\Column(type="text", options={"comment"="配置值"})
     */
    private ?string $value;

    /**
     * @ORM\Column(type="integer",length=3,options={"comment"="配置类型【1-网站信息；2-网站协议；3-客服信息；4-返佣比例配置；5-充值比例设置】"})
     */
    private ?int $type;

    /**
     * @ORM\Column(type="string",length=255)
     */
    private ?string $nameNotes;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getConfigKey(): ?string
    {
        return $this->config_key;
    }

    public function setConfigKey(string $config_key): self
    {
        $this->config_key = $config_key;

        return $this;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): self
    {
        $this->value = $value;

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

    public function getNameNotes(): ?string
    {
        return $this->nameNotes;
    }

    public function setNameNotes(string $nameNotes): self
    {
        $this->nameNotes = $nameNotes;

        return $this;
    }
}
