<?php

namespace App\Entity;

use App\Repository\CommonProblemRepository;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass=CommonProblemRepository::class)
 * @ORM\Table(options={"comment"="常见问题表"},indexes={@ORM\Index(name="title_idx",columns={"title"})})
 * @Gedmo\SoftDeleteable(fieldName="deletedTime")
 */
class CommonProblem
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\Column(type="string",length=255,options={"comment"="标题"})
     */
    private ?string $title;

    /**
     * @ORM\Column(type="string", length=600,options={"comment"="内容"})
     */
    private ?string $content;

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

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

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
