<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Groups;
use App\Repository\FavoritesRepository;

#[ORM\Entity(repositoryClass: FavoritesRepository::class)]
class Favorites
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["getUsers"])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'favorites')]
    private ?User $user = null;

    #[ORM\Column(length: 255)]
    #[Groups(["getUsers"])]
    private ?string $dpeNumber = null;

    #[ORM\Column(length: 255)]
    #[Groups(["getUsers"])]
    private ?string $dpeDate = null;

    #[ORM\Column(length: 255)]
    #[Groups(["getUsers"])]
    private ?string $dpeClass = null;

    #[ORM\Column(length: 255)]
    #[Groups(["getUsers"])]
    private ?string $adress = null;

    #[ORM\Column(length: 255)]
    #[Groups(["getUsers"])]
    private ?string $buildingType = null;

    #[ORM\Column(length: 255)]
    #[Groups(["getUsers"])]
    private ?string $areaSize = null;

    #[ORM\Column(length: 255)]
    #[Groups(["getUsers"])]
    private ?string $latitude = null;

    #[ORM\Column(length: 255)]
    #[Groups(["getUsers"])]
    private ?string $longitude = null;

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

    public function getDpeNumber(): ?string
    {
        return $this->dpeNumber;
    }

    public function setDpeNumber(string $dpeNumber): self
    {
        $this->dpeNumber = $dpeNumber;

        return $this;
    }

    public function getDpeDate(): ?string
    {
        return $this->dpeDate;
    }

    public function setDpeDate(string $dpeDate): self
    {
        $this->dpeDate = $dpeDate;

        return $this;
    }

    public function getdpeClass(): ?string
    {
        return $this->dpeClass;
    }

    public function setdpeClass(string $dpeClass): self
    {
        $this->dpeClass = $dpeClass;

        return $this;
    }

    public function getAdress(): ?string
    {
        return $this->adress;
    }

    public function setAdress(string $adress): self
    {
        $this->adress = $adress;

        return $this;
    }

    public function getBuildingType(): ?string
    {
        return $this->buildingType;
    }

    public function setBuildingType(string $buildingType): self
    {
        $this->buildingType = $buildingType;

        return $this;
    }

    public function getAreaSize(): ?string
    {
        return $this->areaSize;
    }

    public function setAreaSize(string $areaSize): self
    {
        $this->areaSize = $areaSize;

        return $this;
    }

    public function getLatitude(): ?string
    {
        return $this->latitude;
    }

    public function setLatitude(string $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?string
    {
        return $this->longitude;
    }

    public function setLongitude(string $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }
}
