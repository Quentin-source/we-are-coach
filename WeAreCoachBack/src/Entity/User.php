<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $user_pseudo;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $city;

    /**
     * @ORM\Column(type="integer")
     */
    private $age;



    /**
     * @ORM\Column(type="string", length=255)
     */
    private $sport1;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $sport2;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $sport3;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $mail;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $picture;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @ORM\OneToMany(targetEntity=comment::class, mappedBy="user")
     */
    private $comment;

    /**
     * @ORM\OneToMany(targetEntity=Workout::class, mappedBy="user")
     */
    private $Workout;

    /**
     * @ORM\OneToMany(targetEntity=rate::class, mappedBy="user")
     */
    private $Rate;

    /**
     * @ORM\OneToOne(targetEntity=Rate::class, mappedBy="User", cascade={"persist", "remove"})
     */
    private $rate;

    /**
     * @ORM\OneToMany(targetEntity=favorite::class, mappedBy="user")
     */
    private $favorite;





    public function __construct()
    {
        $this->comment = new ArrayCollection();
        $this->Workout = new ArrayCollection();
        $this->Rate = new ArrayCollection();
        $this->favorite = new ArrayCollection();

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserPseudo(): ?string
    {
        return $this->user_pseudo;
    }

    public function setUserPseudo(string $user_pseudo): self
    {
        $this->user_pseudo = $user_pseudo;

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

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

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

    public function setSport2(string $sport2): self
    {
        $this->sport2 = $sport2;

        return $this;
    }


    public function getSport3(): ?string
    {
        return $this->sport3;
    }

    public function setSport3(string $sport3): self
    {
        $this->sport3 = $sport3;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): self
    {
        $this->mail = $mail;

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

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

        /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        // On récupère les roles associés à l'utilisateur
        // Pour demo2, $roles = [];
        // Pour adrien, $roles = ["ROLE_ADMIN"];
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER'; // ["ROLE_ADMIN", "ROLE_USER"]

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @return Collection|comment[]
     */
    public function getComment(): Collection
    {
        return $this->Comment;
    }

    public function addComment(comment $comment): self
    {
        if (!$this->comment->contains($comment)) {
            $this->comment[] = $comment;
            $comment->setUser($this);
        }

        return $this;
    }

    public function removeComment(comment $comment): self
    {
        if ($this->comment->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getUser() === $this) {
                $comment->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|workout[]
     */
    public function getWorkout(): Collection
    {
        return $this->Workout;
    }

    public function addWorkout(workout $workout): self
    {
        if (!$this->Workout->contains($workout)) {
            $this->Workout[] = $workout;
            $workout->setUser($this);
        }

        return $this;
    }

    public function removeWorkout(workout $workout): self
    {
        if ($this->Workout->removeElement($workout)) {
            // set the owning side to null (unless already changed)
            if ($workout->getUser() === $this) {
                $workout->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|rate[]
     */
    public function getRate(): Collection
    {
        return $this->Rate;
    }

    public function addRate(rate $rate): self
    {
        if (!$this->Rate->contains($rate)) {
            $this->Rate[] = $rate;
            $rate->setUser($this);
        }

        return $this;
    }

    public function removeRate(rate $rate): self
    {
        if ($this->Rate->removeElement($rate)) {
            // set the owning side to null (unless already changed)
            if ($rate->getUser() === $this) {
                $rate->setUser(null);
            }
        }

        return $this;
    }

    public function setRate(Rate $rate): self
    {
        // set the owning side of the relation if necessary
        if ($rate->getUser() !== $this) {
            $rate->setUser($this);
        }

        $this->rate = $rate;

        return $this;
    }

    /**
     * @return Collection|favorite[]
     */
    public function getFavorite(): Collection
    {
        return $this->favorite;
    }

    public function addFavorite(favorite $favorite): self
    {
        if (!$this->favorite->contains($favorite)) {
            $this->favorite[] = $favorite;
            $favorite->setUser($this);
        }

        return $this;
    }

    public function removeFavorite(favorite $favorite): self
    {
        if ($this->favorite->removeElement($favorite)) {
            // set the owning side to null (unless already changed)
            if ($favorite->getUser() === $this) {
                $favorite->setUser(null);
            }
        }

        return $this;
    }

    public function setFavorite(Favorite $favorite): self
    {
        // set the owning side of the relation if necessary
        if ($favorite->getUser() !== $this) {
            $favorite->setUser($this);
        }

        $this->favorite = $favorite;

        return $this;
    }

}
