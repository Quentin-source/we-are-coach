<?php

namespace App\Entity;

use App\Repository\SportRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=SportRepository::class)
 */
class Sport
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"workout_list","workout_detail","sport_detail"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"workout_list","workout_detail","sport_detail"})
     */
    private $name;


    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"sport_detail"})
     */
    private $picture;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="Sport")
     * @Groups({"workout_list","sport_detail"})
     */
    private $category;

    /**
     * @ORM\OneToMany(targetEntity=Workout::class, mappedBy="sport")
     * 
     */
    private $workout;

    public function __construct()
    {
        $this->workout = new ArrayCollection();
    }
    
    public function __toString()
    {
        return $this->id . ' - ' . $this->name;
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
     * @return Collection|Workout[]
     */

    // public function getWorkout(): Collection
    // {
    //     return $this->Workout;
    // }

    public function addWorkout(Workout $workout): self
    {
        if (!$this->workout->contains($workout)) {
            $this->workout[] = $workout;
            $workout->setSport($this);
        }

        return $this;
    }

    public function removeWorkout(Workout $workout): self
    {
        if ($this->workout->removeElement($workout)) {
            // set the owning side to null (unless already changed)
            if ($workout->getSport() === $this) {
                $workout->setSport(null);
            }
        }

        return $this;
    }

}
