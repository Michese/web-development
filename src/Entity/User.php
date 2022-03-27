<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements \Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $first_name;

    #[ORM\Column(type: 'string', length: 255)]
    private $last_name;

    #[ORM\Column(type: 'string', length: 255)]
    private $email;

    #[ORM\Column(type: 'bigint', nullable: true)]
    private $phone;

    #[ORM\ManyToOne(targetEntity: Role::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $role;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $api_token;

    #[ORM\OneToMany(mappedBy: 'admin', targetEntity: NewItem::class, orphanRemoval: true)]
    private $news;

    #[ORM\OneToMany(mappedBy: 'admin', targetEntity: Comment::class)]
    private $adminComments;

    #[ORM\Column(type: 'string', length: 255)]
    private $password;

    #[ORM\Column(type: 'datetime')]
    private $last_day_visit;

    public function __construct()
    {
        $this->news = new ArrayCollection();
        $this->adminComments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    public function setFirstName(string $first_name): self
    {
        $this->first_name = $first_name;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    public function setLastName(string $last_name): self
    {
        $this->last_name = $last_name;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getRole(): ?Role
    {
        return $this->role;
    }

    public function setRole(?Role $role): self
    {
        $this->role = $role;

        return $this;
    }

    public function getApiToken(): ?string
    {
        return $this->api_token;
    }

    public function setApiToken(?string $api_token): self
    {
        $this->api_token = $api_token;

        return $this;
    }

    /**
     * @return Collection<int, NewItem>
     */
    public function getNews(): Collection
    {
        return $this->news;
    }

    public function addNews(NewItem $news): self
    {
        if (!$this->news->contains($news)) {
            $this->news[] = $news;
            $news->setAdmin($this);
        }

        return $this;
    }

    public function removeNews(NewItem $news): self
    {
        if ($this->news->removeElement($news)) {
            // set the owning side to null (unless already changed)
            if ($news->getAdmin() === $this) {
                $news->setAdmin(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getAdminComments(): Collection
    {
        return $this->adminComments;
    }

    public function addAdminComment(Comment $adminComment): self
    {
        if (!$this->adminComments->contains($adminComment)) {
            $this->adminComments[] = $adminComment;
            $adminComment->setAdmin($this);
        }

        return $this;
    }

    public function removeAdminComment(Comment $adminComment): self
    {
        if ($this->adminComments->removeElement($adminComment)) {
            // set the owning side to null (unless already changed)
            if ($adminComment->getAdmin() === $this) {
                $adminComment->setAdmin(null);
            }
        }

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getLastDayVisit(): ?\DateTimeInterface
    {
        return $this->last_day_visit;
    }

    public function setLastDayVisit(\DateTimeInterface $last_day_visit): self
    {
        $this->last_day_visit = $last_day_visit;

        return $this;
    }
}
