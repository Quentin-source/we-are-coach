<?php

namespace App\Entity;

use App\Repository\WorkoutRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=WorkoutRepository::class)
 */
class Workout
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
    private $name;



    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="integer")
     */
    private $level;


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $picture;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $published_at;


    /**
     * @ORM\OneToMany(targetEntity=comment::class, mappedBy="workout")
     */
    private $Comment;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="Workout")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Sport::class, inversedBy="Workout")
     */
    private $sport;

    /**
     * @ORM\OneToMany(targetEntity=rate::class, mappedBy="workout")
     */
    private $Rate;

    /**
     * @ORM\OneToOne(targetEntity=Rate::class, mappedBy="Workout", cascade={"persist", "remove"})
     */
    private $rate;

    /**
     * @ORM\OneToMany(targetEntity=favorite::class, mappedBy="workout")
     */
    private $Favorite;



    public function __construct()
    {
        $this->Comment = new ArrayCollection();
        $this->Rate = new ArrayCollection();
        $this->Favorite = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
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



    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getLevel(): ?int
    {
        return $this->level;
    }

    public function setLevel(int $level): self
    {
        $this->level = $level;

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

    public function getPublishedAt(): ?\DateTimeImmutable
    {
        return $this->published_at;
    }

    public function setPublishedAt(\DateTimeImmutable $published_at): self
    {
        $this->published_at = $published_at;

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
            $comment->setWorkout($this);
        }

        return $this;
    }

    public function removeComment(comment $comment): self
    {
        if ($this->Comment->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getWorkout() === $this) {
                $comment->setWorkout(null);
            }
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getSport(): ?Sport
    {
        return $this->sport;
    }

    public function setSport(?Sport $sport): self
    {
        $this->sport = $sport;

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
            $rate->setWorkout($this);
        }

        return $this;
    }

    public function removeRate(rate $rate): self
    {
        if ($this->Rate->removeElement($rate)) {
            // set the owning side to null (unless already changed)
            if ($rate->getWorkout() === $this) {
                $rate->setWorkout(null);
            }
        }

        return $this;
    }

    public function setRate(Rate $rate): self
    {
        // set the owning side of the relation if necessary
        if ($rate->getWorkout() !== $this) {
            $rate->setWorkout($this);
        }

        $this->rate = $rate;

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
            $favorite->setWorkout($this);
        }

        return $this;
    }

    public function removeFavorite(favorite $favorite): self
    {
        if ($this->Favorite->removeElement($favorite)) {
            // set the owning side to null (unless already changed)
            if ($favorite->getWorkout() === $this) {
                $favorite->setWorkout(null);
            }
        }

        return $this;
    }



}
