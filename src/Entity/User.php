<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="`user`")
 * @UniqueEntity(
 *     fields="email",
 *     message="Такой email уже существует!"
 * )
 * @UniqueEntity(
 *     fields="phone",
 *     message="Такой номер телефона уже существует!"
 * )
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer", nullable=false)
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true, nullable=false)
     * @Assert\Email(
     *     message = "Некорректный email",
     * )
     * @Assert\Regex(
     *     pattern="/^[a-z]+.+@[a-z]{2,}.[a-z]{2,}$/i",
     *     message = "Некорректный email",
     * )
     */
    private $email;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @Assert\Length(
     *      min = 6,
     *      minMessage = "Ваш пароль должен быть как минимум {{ limit }} символов",
     * )
     * @Assert\Regex(
     *     pattern="/[a-zA-Z]/i",
     *     message="Добавьте хотя бы одну латинскую букву"
     * )
     */
    private $password;

    /**
     * @ORM\Column(type="bigint", nullable=false)
     * @Assert\Range(
     *      min = 89000000000,
     *      max = 89999999999,
     *      minMessage = "Некорректный номер телефона!",
     *      maxMessage = "Некорректный номер телефона!"
     * )
     */
    private $phone;

    /**
     * @ORM\Column(type="string", nullable=false, length=255)
     * @Assert\Length(
     *      min = 4,
     *      max = 20,
     *      minMessage = "Ваше имя должно быть как минимум {{ limit }} символа",
     *      maxMessage = "Ваше имя не должно быть длиннее {{ limit }} символов"
     * )
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=Post::class, mappedBy="author")
     */
    private $posts;

    /**
     * @ORM\OneToMany(targetEntity=PostRating::class, mappedBy="user")
     */
    private $postRatings;

    /**
     * @ORM\Column(type="string", nullable=true, unique=true)
     */
    private $apiToken;

    public function __construct()
    {
        $this->posts = new ArrayCollection();
        $this->postRatings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = mb_strtolower($email);

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string)$this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string)$this->email;
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

    public function checkPassword(string $password): bool
    {
        return password_verify($password, $this->password);
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|Post[]
     */
    public function getPosts(): Collection
    {
        return $this->posts;
    }

    public function addPost(Post $post): self
    {
        if (!$this->posts->contains($post)) {
            $this->posts[] = $post;
            $post->setAuthor($this);
        }

        return $this;
    }

    public function removePost(Post $post): self
    {
        if ($this->posts->removeElement($post)) {
            // set the owning side to null (unless already changed)
            if ($post->getAuthor() === $this) {
                $post->setAuthor(null);
            }
        }

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
            $postRating->setUserId($this);
        }

        return $this;
    }

    public function removePostRating(PostRating $postRating): self
    {
        if ($this->postRatings->removeElement($postRating)) {
            // set the owning side to null (unless already changed)
            if ($postRating->getUserId() === $this) {
                $postRating->setUserId(null);
            }
        }

        return $this;
    }

    public function getApiToken(): ?string
    {
        return $this->apiToken;
    }

    public function setApiToken(?string $apiToken): self
    {
        $this->apiToken = $apiToken;

        return $this;
    }
}
