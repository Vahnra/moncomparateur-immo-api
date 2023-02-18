<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\DBAL\Types\Types;
use JMS\Serializer\Annotation\Groups;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["getOrder"])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'orders')]
    private ?User $user = null;

    #[ORM\Column]
    #[Groups(["getOrder"])]
    private ?int $orderId = null;

    #[ORM\Column(length: 255)]
    #[Groups(["getOrder"])]
    private ?string $status = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $customerId = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(["getOrder"])]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(["getOrder"])]
    private ?string $price = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(["getOrder"])]
    private ?string $type = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $subscriptionId = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $subscriptionStatus = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(["getOrder"])]
    private ?string $subStartDate = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getOrderId(): ?int
    {
        return $this->orderId;
    }

    public function setOrderId(int $orderId): self
    {
        $this->orderId = $orderId;

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

    public function getCustomerId(): ?string
    {
        return $this->customerId;
    }

    public function setCustomerId(?string $customerId): self
    {
        $this->customerId = $customerId;

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

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(?string $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getSubscriptionId(): ?string
    {
        return $this->subscriptionId;
    }

    public function setSubscriptionId(?string $subscriptionId): self
    {
        $this->subscriptionId = $subscriptionId;

        return $this;
    }

    public function getSubscriptionStatus(): ?string
    {
        return $this->subscriptionStatus;
    }

    public function setSubscriptionStatus(?string $subscriptionStatus): self
    {
        $this->subscriptionStatus = $subscriptionStatus;

        return $this;
    }

    public function getSubStartDate(): ?string
    {
        return $this->subStartDate;
    }

    public function setSubStartDate(?string $subStartDate): self
    {
        $this->subStartDate = $subStartDate;

        return $this;
    }

}
