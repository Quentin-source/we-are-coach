<?php

namespace App\Entity;

use App\Repository\CommentRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=CommentRepository::class)
 */
class Comment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"workout_detail","comment_list","comment_detail"})
     */
    private $id;


    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"workout_detail", "comment_list","comment_detail"})
     */
    private $comment;

    /**
     * @ORM\Column(type="datetime_immutable")
     * @Groups({"workout_detail", "comment_list","comment_detail"})
     * 
     */
    private $published_at;

    /**
     * @ORM\ManyToOne(targetEntity=Workout::class, inversedBy="comment")
     */
    private $workout;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="comment")
     * @Groups({"workout_detail","comment_detail"})
     */
    private $user;

    public function __toString()
    {
        return $this->comment;
    }

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(string $comment): self
    {
        $this->comment = $comment;

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

    public function getWorkout(): ?Workout
    {
        return $this->workout;
    }

    public function setWorkout(?Workout $workout): self
    {
        $this->workout = $workout;

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
    
}
