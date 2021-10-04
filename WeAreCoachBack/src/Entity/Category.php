<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 */
class Category
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"category_list","workout_list","sport_detail","category_detail"})
     * 
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"category_list","workout_list","sport_detail","category_detail"})
     * 
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"category_list","sport_detail","category_detail"})
     */
    private $picture;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"category_list","sport_detail","category_detail"})
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity=Sport::class, mappedBy="category")
     * @Groups({"category_list","category_detail"})
     */
    private $Sport;



    public function __construct()
    {
        $this->Sport = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->pictudescriptionre = $description;

        return $this;
    }

    /**
     * @return Collection|sport[]
     */
    public function getSport(): Collection
    {
        return $this->Sport;
    }

    public function addSport(sport $sport): self
    {
        if (!$this->Sport->contains($sport)) {
            $this->Sport[] = $sport;
            $sport->setCategory($this);
        }

        return $this;
    }

    public function removeSport(sport $sport): self
    {
        if ($this->Sport->removeElement($sport)) {
            // set the owning side to null (unless already changed)
            if ($sport->getCategory() === $this) {
                $sport->setCategory(null);
            }
        }

        return $this;
    }

}
