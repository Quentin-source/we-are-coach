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
    private $sport;

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
     * @ORM\OneToMany(targetEntity=comment::class, mappedBy="user")
     */
    private $Comment;

    /**
     * @ORM\OneToMany(targetEntity=workout::class, mappedBy="user")
     */
    private $Workout;

    /**
     * @ORM\OneToMany(targetEntity=rate::class, mappedBy="user")
     */
    private $Rate;

    /**
     * @ORM\OneToMany(targetEntity=favorite::class, mappedBy="user")
     */
    private $Favorite;

    public function __construct()
    {
        $this->Comment = new ArrayCollection();
        $this->Workout = new ArrayCollection();
        $this->Rate = new ArrayCollection();
        $this->Favorite = new ArrayCollection();
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

    public function getSport(): ?string
    {
        return $this->sport;
    }

    public function setSport(string $sport): self
    {
        $this->sport = $sport;

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
     * @return Collection|comment[]
     */
    public function getComment(): Collection
    {
        return $this->Comment;
    }

    public function addComment(comment $comment): self
    {
        if (!$this->Comment->contains($comment)) {
            $this->Comment[] = $comment;
            $comment->setUser($this);
        }

        return $this;
    }

    public function removeComment(comment $comment): self
    {
        if ($this->Comment->removeElement($comment)) {
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

    /**
     * @return Collection|favorite[]
     */
    public function getFavorite(): Collection
    {
        return $this->Favorite;
    }

    public function addFavorite(favorite $favorite): self
    {
        if (!$this->Favorite->contains($favorite)) {
            $this->Favorite[] = $favorite;
            $favorite->setUser($this);
        }

        return $this;
    }

    public function removeFavorite(favorite $favorite): self
    {
        if ($this->Favorite->removeElement($favorite)) {
            // set the owning side to null (unless already changed)
            if ($favorite->getUser() === $this) {
                $favorite->setUser(null);
            }
        }

        return $this;
    }
}
