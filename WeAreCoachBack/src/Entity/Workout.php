<?php

namespace App\Entity;

use App\Repository\WorkoutRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;



/**
 * @ORM\Entity(repositoryClass=WorkoutRepository::class)
 */
class Workout
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"latest_workout"})
     * @Groups({"workout_list","workout_detail","comment_add","favorite_list","favorite_detail","user_detail"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"latest_workout"})
     * @Groups({"workout_list","workout_detail","favorite_list","favorite_detail"})
     */
    private $name;



    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"latest_workout"})
     * @Groups({"workout_list","workout_detail"})
     */
    private $description;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"workout_list","workout_detail"})
     */
    private $level;


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"latest_workout"})
     * @Groups({"workout_list","workout_detail"})
     */
    private $picture;

    /**
     * @ORM\Column(type="datetime_immutable")
     * @Groups({"workout_list","workout_detail"})
     */
    private $published_at;


    /**
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="workout")
     * @Groups({"workout_detail"})
     */
    private $comment;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="Workout")
     * @Groups({"workout_detail"})
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Sport::class, inversedBy="workout")
     * @Groups({"workout_list","workout_detail"})
     */
    private $sport;

    /**
     * @ORM\OneToMany(targetEntity=Rate::class, mappedBy="workout")
     * @Groups({"workout_list","workout_detail"})
     */
    private $rate;



    /**
     * @ORM\OneToMany(targetEntity=Favorite::class, mappedBy="workout")
     * 
     */
    private $favorite;



    public function __construct()
    {
        $this->comment = new ArrayCollection();
        $this->rate = new ArrayCollection();
        $this->favorite = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->name;
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
     * @return Collection|Comment[]
     */
    public function getComment(): Collection
    {
        return $this->comment;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comment->contains($comment)) {
            $this->comment[] = $comment;
            $comment->setWorkout($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comment->removeElement($comment)) {
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
     * @return Collection|Rate[]
     */
    public function getRate(): Collection
    {
        return $this->rate;
    }

    public function addRate(Rate $rate): self
    {
        if (!$this->rate->contains($rate)) {
            $this->rate[] = $rate;
            $rate->setWorkout($this);
        }

        return $this;
    }

    public function removeRate(Rate $rate): self
    {
        if ($this->rate->removeElement($rate)) {
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
     * @return Collection|Favorite[]
     */
    public function getFavorite(): Collection
    {
        return $this->favorite;
    }

    public function addFavorite(Favorite $favorite): self
    {
        if (!$this->favorite->contains($favorite)) {
            $this->favorite[] = $favorite;
            $favorite->setWorkout($this);
        }

        return $this;
    }

    public function removeFavorite(Favorite $favorite): self
    {
        if ($this->favorite->removeElement($favorite)) {
            // set the owning side to null (unless already changed)
            if ($favorite->getWorkout() === $this) {
                $favorite->setWorkout(null);
            }
        }

        return $this;
    }



}
