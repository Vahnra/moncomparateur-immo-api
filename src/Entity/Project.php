<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProjectRepository;
use JMS\Serializer\Annotation\Groups;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: ProjectRepository::class)]
class Project
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["getProject"])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(["getProject"])]
    private ?string $type = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(["getProject"])]
    private ?string $city = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(["getProject"])]
    private ?string $adress = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(["getProject"])]
    private ?string $complementAdress = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(["getProject"])]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(["getProject"])]
    private ?\DateTimeInterface $updatedAt = null;

    #[ORM\OneToMany(mappedBy: 'project', targetEntity: Comment::class)]
    #[Groups(["getProject"])]
    private Collection $comments;

    #[ORM\ManyToOne(inversedBy: 'projects')]
    #[Groups(["getProject"])]
    private ?User $user = null;

    #[ORM\Column(nullable: true)]
    #[Groups(["getProject"])]
    private ?int $phoneNumbers = null;

    #[ORM\Column(length: 255)]
    #[Groups(["getProject"])]
    private ?string $status = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $email = null;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getAdress(): ?string
    {
        return $this->adress;
    }

    public function setAdress(?string $adress): self
    {
        $this->adress = $adress;

        return $this;
    }

    public function getComplementAdress(): ?string
    {
        return $this->complementAdress;
    }

    public function setComplementAdress(?string $complementAdress): self
    {
        $this->complementAdress = $complementAdress;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
            $comment->setProject($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getProject() === $this) {
                $comment->setProject(null);
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

    public function getPhoneNumbers(): ?int
    {
        return $this->phoneNumbers;
    }

    public function setPhoneNumbers(?int $phoneNumbers): self
    {
        $this->phoneNumbers = $phoneNumbers;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }
}
