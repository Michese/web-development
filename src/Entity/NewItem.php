<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\MongoDbOdm\Filter\OrderFilter;
use ApiPlatform\Core\Bridge\Doctrine\MongoDbOdm\Filter\RangeFilter;
use ApiPlatform\Core\Bridge\Doctrine\MongoDbOdm\Filter\ExistsFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\DateFilter;
use ApiPlatform\Core\Serializer\Filter\PropertyFilter;
use App\Repository\NewItemRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: NewItemRepository::class)]
#[ApiResource(
    collectionOperations: ['get' => [
        'normalization_context' => ['groups' => ['news']],
        'pagination_items_per_page' => 3,
        'order' => ["createdAt" => "DESC"],
    ]],
    itemOperations: [
        'get' => [
            'controller' => '\App\Controller\HomeController::getPost',
            'path' => '/new_items/{id}',
            'method' => 'GET',
        ],
        'post' => [
            'method' => 'POST',
            'route_name' => 'create_new',
            "security" => "is_granted('ROLE_ADMIN')"
        ],
        'put' => [
            'method' => 'PUT',
            'route_name' => 'edit_new',
            "security" => "is_granted('ROLE_ADMIN')"
        ],
        'delete' => [
            'method' => 'DELETE',
            'route_name' => 'delete_new',
            "security" => "is_granted('ROLE_ADMIN')"
        ],
    ]
)]
class NewItem
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['new', 'news'])]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['new', 'news'])]
    private $title;

    #[ORM\Column(type: 'string', length: 1023)]
    #[Groups(['new', 'news'])]
    private $description;

    #[ORM\Column(type: 'text')]
    #[Groups(['new'])]
    private $text;

    #[ORM\Column(type: 'datetime_immutable')]
    #[Groups(['new', 'news'])]
    private $createdAt;

    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    private $deletedAt;

    #[ORM\Column(type: 'integer', options: ['default' => 0])]
    #[Groups(['new'])]
    private $views = 0;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'newItems')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['new'])]
    private $admin;

    #[ORM\OneToMany(mappedBy: 'new', targetEntity: Comment::class, cascade: ['remove'])]
    private $comments;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $image;

    #[Pure] public function __construct()
    {
        $this->comments = new ArrayCollection();
    }

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

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

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getDeletedAt(): ?\DateTimeImmutable
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(\DateTimeImmutable $deletedAt): self
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    public function getViews(): ?int
    {
        return $this->views;
    }

    public function setViews(int $views): self
    {
        $this->views = $views;

        return $this;
    }

    public function getAdmin(): ?User
    {
        return $this->admin;
    }

    public function setAdmin(?User $admin): self
    {
        $this->admin = $admin;

        return $this;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    #[Pure]
    #[Groups(['news'])]
    public function getCountComments(): int
    {
        return $this->comments->filter(function ($comment) {
            return $comment->getDeletedAt() == null;
        })->count();
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setNew($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getNew() === $this) {
                $comment->setNew(null);
            }
        }

        return $this;
    }

    #[Groups(['new', 'news'])]
    public function getImage(): ?string
    {
        if ($this->image) {
            return $this->image;
        } else {
            return null;
        }
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }
}
