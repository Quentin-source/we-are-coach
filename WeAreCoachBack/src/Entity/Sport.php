<?php

namespace App\Entity;

use App\Repository\SportRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SportRepository::class)
 */
class Sport
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
    private $picture;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="Sport")
     */
    private $category;

    /**
     * @ORM\OneToMany(targetEntity=workout::class, mappedBy="sport")
     */
    private $Workout;

    public function __construct()
    {
        $this->Workout = new ArrayCollection();
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


    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

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
            $workout->setSport($this);
        }

        return $this;
    }

    public function removeWorkout(workout $workout): self
    {
        if ($this->Workout->removeElement($workout)) {
            // set the owning side to null (unless already changed)
            if ($workout->getSport() === $this) {
                $workout->setSport(null);
            }
        }

        return $this;
    }

}
