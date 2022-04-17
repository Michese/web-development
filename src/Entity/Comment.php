<?php

namespace App\Entity;

use App\Repository\CommentRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommentRepository::class)]
class Comment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'comments')]
    #[ORM\JoinColumn(nullable: false)]
    private $userId;

    #[ORM\ManyToOne(targetEntity: User::class)]
    private $adminId;

    #[ORM\Column(type: 'datetime_immutable')]
    private $createdAt;

    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    private $deletedAt;

    #[ORM\Column(type: 'text')]
    private $text;

    #[ORM\ManyToOne(targetEntity: NewItem::class, inversedBy: 'comments')]
    #[ORM\JoinColumn(nullable: false)]
    private $new;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): ?User
    {
        return $this->userId;
    }

    public function setUserId(?User $userId): self
    {
        $this->userId = $userId;

        return $this;
    }

    public function getAdminId(): ?User
    {
        return $this->adminId;
    }

    public function setAdminId(?User $adminId): self
    {
        $this->adminId = $adminId;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getDeltedAt(): ?\DateTimeImmutable
    {
        return $this->deltedAt;
    }

    public function setDeltedAt(?\DateTimeImmutable $deltedAt): self
    {
        $this->deltedAt = $deltedAt;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getNew(): ?NewItem
    {
        return $this->new;
    }

    public function setNew(?NewItem $new): self
    {
        $this->new = $new;

        return $this;
    }
}
