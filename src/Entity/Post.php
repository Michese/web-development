<?php

namespace App\Entity;

use App\Repository\PostRepository;
use App\Service\FileManagerService;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=PostRepository::class)
 */
class Post
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=1023)
     */
    private $image;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
     *      min = 1,
     *      minMessage = "Название должно быть как минимум из {{ limit }} символа",
     * )
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=0, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private $deleted_at;

    /**
     * @ORM\OneToMany(targetEntity=PostRating::class, mappedBy="post")
     */
    private $postRatings;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $author;

    /**
     * @ORM\Column(type="bigint")
     */
    private $user_id;

    /**
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="post", orphanRemoval=true)
     */
    private $comments;

    /**
     * @ORM\ManyToOne(targetEntity=Tag::class, inversedBy="posts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $tag;

    public function __construct()
    {
        $this->postRatings = new ArrayCollection();
        $this->comments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImage(): ?string
    {
        $fileManagerService = new FileManagerService();
        return $fileManagerService->getImage($this->image);
    }

    /**
     * @throws \Exception
     */
    public function setImage(string $image): self
    {
        $fileManagerService = new FileManagerService();
        $this->image = $fileManagerService->imagePostUpload($image);

        return $this;
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

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at = null): self
    {
        if ($created_at == null) {
            $this->created_at = (new \DateTimeImmutable ('now'));
        } else {
            $this->created_at = $created_at;
        }

        return $this;
    }

    public function getDeletedAt(): ?\DateTimeImmutable
    {
        return $this->deleted_at;
    }

    public function setDeletedAt(?\DateTimeImmutable $deleted_at): self
    {
        $this->deleted_at = $deleted_at;

        return $this;
    }

    /**
     * @return Collection|PostRating[]
     */
    public function getPostRatings(): Collection
    {
        return $this->postRatings;
    }

    public function addPostRating(PostRating $postRating): self
    {
        if (!$this->postRatings->contains($postRating)) {
            $this->postRatings[] = $postRating;
            $postRating->setPostId($this);
        }

        return $this;
    }

    public function removePostRating(PostRating $postRating): self
    {
        if ($this->postRatings->removeElement($postRating)) {
            // set the owning side to null (unless already changed)
            if ($postRating->getPostId() === $this) {
                $postRating->setPostId(null);
            }
        }

        return $this;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(?string $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getUserId(): ?string
    {
        return $this->user_id;
    }

    public function setUserId(string $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setPost($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getPost() === $this) {
                $comment->setPost(null);
            }
        }

        return $this;
    }

    public function getTag(): ?Tag
    {
        return $this->tag;
    }

    public function setTag(?Tag $tag): self
    {
        $this->tag = $tag;

        return $this;
    }
}
