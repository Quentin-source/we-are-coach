<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"user_list"})
     * @Groups({"workout_list","workout_detail","user_detail","comment_add","favorite_list","favorite_detail"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Groups({"user_list","user_detail"})
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     * @Groups({"user_list","user_detail"})
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @Groups({"user_list","user_detail"})
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"user_list"})
     * @Groups({"workout_list","workout_detail","user_detail","favorite_list","favorite_detail"})
     */
    private $pseudo;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"user_list","user_detail", "comment_detail"})
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"user_list","user_detail"})
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"user_list","user_detail"})
     */
    private $city;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"user_list","user_detail"})
     */
    private $age;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"user_list","user_detail"})
     */
    private $sport1;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"user_list","user_detail"})
     */
    private $sport2;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"user_list","user_detail"})
     */
    private $sport3;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"user_list","user_detail"})
     */
    private $picture;

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
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
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

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): self
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(int $age): self
    {
        $this->age = $age;

        return $this;
    }

    public function getSport1(): ?string
    {
        return $this->sport1;
    }

    public function setSport1(string $sport1): self
    {
        $this->sport1 = $sport1;

        return $this;
    }

    public function getSport2(): ?string
    {
        return $this->sport2;
    }

    public function setSport2(?string $sport2): self
    {
        $this->sport2 = $sport2;

        return $this;
    }

    public function getSport3(): ?string
    {
        return $this->sport3;
    }

    public function setSport3(?string $sport3): self
    {
        $this->sport3 = $sport3;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }
}
