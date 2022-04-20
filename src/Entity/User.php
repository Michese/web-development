<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[Groups(['user', 'new'])]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[Groups(['user'])]
    #[ORM\Column(type: 'string', length: 180, unique: true)]
    private $email;

    #[ORM\Column(type: 'json')]
    private $roles = [];

    #[ORM\Column(type: 'string')]
    private $password;

    #[Groups(['user', 'new'])]
    #[ORM\Column(type: 'string', length: 255)]
    private $firstName;

    #[Groups(['user', 'new'])]
    #[ORM\Column(type: 'string', length: 255)]
    private $lastName;

    #[Groups(['user'])]
    #[ORM\Column(type: 'bigint')]
    private $phone;

    #[Groups(['user'])]
    #[ORM\Column(type: 'datetime_immutable')]
    private $lastDayVisit;

    #[ORM\OneToMany(mappedBy: 'admin', targetEntity: NewItem::class)]
    private $newItems;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Comment::class)]
    private $comments;


    #[ArrayShape(["id" => "int|null", "firstName" => "null|string", "email" => "null|string", "lastName" => "null|string", "phone" => "null|string", "lastDayVisit" => "\DateTimeInterface|null", "roles" => "array|string[]"])] public function toArray(): array
    {
        return [
            "id" => $this->getId(),
            "firstName" => $this->getFirstName(),
            "email" => $this->getEmail(),
            "lastName" => $this->getFirstName(),
            "phone" => $this->getPhone(),
            "lastDayVisit" => $this->getLastDayVisit(),
            "roles" => $this->getRoles(),
        ];
    }

    #[Pure] public function __construct()
    {
        $this->newItems = new ArrayCollection();
        $this->comments = new ArrayCollection();
    }

    /**
     * @see UserInterface
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @see UserInterface
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @see UserInterface
     */
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getLastDayVisit(): ?\DateTimeInterface
    {
        return $this->lastDayVisit;
    }

    public function setLastDayVisit(\DateTimeInterface $lastDayVisit): self
    {
        $this->lastDayVisit = $lastDayVisit;

        return $this;
    }

    /**
     * @see UserInterface
     * @return Collection<int, NewItem>
     */
    public function getNewItems(): Collection
    {
        return $this->newItems;
    }

    public function addNewItem(NewItem $newItem): self
    {
        if (!$this->newItems->contains($newItem)) {
            $this->newItems[] = $newItem;
            $newItem->setAdmin($this);
        }

        return $this;
    }

    public function removeNewItem(NewItem $newItem): self
    {
        if ($this->newItems->removeElement($newItem)) {
            // set the owning side to null (unless already changed)
            if ($newItem->getAdmin() === $this) {
                $newItem->setAdmin(null);
            }
        }

        return $this;
    }

    /**
     * @see UserInterface
     * @return Collection<int, Comment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setUser($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getUser() === $this) {
                $comment->setUser(null);
            }
        }

        return $this;
    }
}
