<?php

namespace App\Entity;

use App\Repository\DvfRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DvfRepository::class)]
class Dvf
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $idMutation = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $dateMutation = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $numeroDisposition = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $natureMutation = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $valeurFonciere = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $adresseNumero = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $adresseSuffixe = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $adresseNomVoie = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $adresseCode = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $codePostal = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $codeCommune = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nomCommune = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $codeDepartement = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $ancienCodeCommune = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $ancienNomCommune = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $idParcelle = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $ancienIdParcelle = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $numeroVolume = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $lot1Numero = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $lot1Surface = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $lot2Numero = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $lot2Surface = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $lot3Numero = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $lot3Surface = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $lo4Numero = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $lot4Surface = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $lot5Numero = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $lot5Surface = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nombreLots = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $codeTypeLocal = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $typeLocal = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $surfaceReelleBatiment = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nombrePiecesPrincipales = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $codeNatureCulture = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $natureCulture = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $codeNatureCultureSpeciale = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $natureCultureSpeciale = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $surfaceTerrain = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $longitude = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $latitude = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdMutation(): ?string
    {
        return $this->idMutation;
    }

    public function setIdMutation(?string $idMutation): self
    {
        $this->idMutation = $idMutation;

        return $this;
    }

    public function getDateMutation(): ?string
    {
        return $this->dateMutation;
    }

    public function setDateMutation(?string $dateMutation): self
    {
        $this->dateMutation = $dateMutation;

        return $this;
    }

    public function getNumeroDisposition(): ?string
    {
        return $this->numeroDisposition;
    }

    public function setNumeroDisposition(?string $numeroDisposition): self
    {
        $this->numeroDisposition = $numeroDisposition;

        return $this;
    }

    public function getNatureMutation(): ?string
    {
        return $this->natureMutation;
    }

    public function setNatureMutation(?string $natureMutation): self
    {
        $this->natureMutation = $natureMutation;

        return $this;
    }

    public function getValeurFonciere(): ?string
    {
        return $this->valeurFonciere;
    }

    public function setValeurFonciere(?string $valeurFonciere): self
    {
        $this->valeurFonciere = $valeurFonciere;

        return $this;
    }

    public function getAdresseNumero(): ?string
    {
        return $this->adresseNumero;
    }

    public function setAdresseNumero(?string $adresseNumero): self
    {
        $this->adresseNumero = $adresseNumero;

        return $this;
    }

    public function getAdresseSuffixe(): ?string
    {
        return $this->adresseSuffixe;
    }

    public function setAdresseSuffixe(?string $adresseSuffixe): self
    {
        $this->adresseSuffixe = $adresseSuffixe;

        return $this;
    }

    public function getAdresseNomVoie(): ?string
    {
        return $this->adresseNomVoie;
    }

    public function setAdresseNomVoie(?string $adresseNomVoie): self
    {
        $this->adresseNomVoie = $adresseNomVoie;

        return $this;
    }

    public function getAdresseCode(): ?string
    {
        return $this->adresseCode;
    }

    public function setAdresseCode(?string $adresseCode): self
    {
        $this->adresseCode = $adresseCode;

        return $this;
    }

    public function getCodePostal(): ?string
    {
        return $this->codePostal;
    }

    public function setCodePostal(?string $codePostal): self
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    public function getCodeCommune(): ?string
    {
        return $this->codeCommune;
    }

    public function setCodeCommune(?string $codeCommune): self
    {
        $this->codeCommune = $codeCommune;

        return $this;
    }

    public function getNomCommune(): ?string
    {
        return $this->nomCommune;
    }

    public function setNomCommune(?string $nomCommune): self
    {
        $this->nomCommune = $nomCommune;

        return $this;
    }

    public function getCodeDepartement(): ?string
    {
        return $this->codeDepartement;
    }

    public function setCodeDepartement(?string $codeDepartement): self
    {
        $this->codeDepartement = $codeDepartement;

        return $this;
    }

    public function getAncienCodeCommune(): ?string
    {
        return $this->ancienCodeCommune;
    }

    public function setAncienCodeCommune(?string $ancienCodeCommune): self
    {
        $this->ancienCodeCommune = $ancienCodeCommune;

        return $this;
    }

    public function getAncienNomCommune(): ?string
    {
        return $this->ancienNomCommune;
    }

    public function setAncienNomCommune(?string $ancienNomCommune): self
    {
        $this->ancienNomCommune = $ancienNomCommune;

        return $this;
    }

    public function getIdParcelle(): ?string
    {
        return $this->idParcelle;
    }

    public function setIdParcelle(?string $idParcelle): self
    {
        $this->idParcelle = $idParcelle;

        return $this;
    }

    public function getAncienIdParcelle(): ?string
    {
        return $this->ancienIdParcelle;
    }

    public function setAncienIdParcelle(?string $ancienIdParcelle): self
    {
        $this->ancienIdParcelle = $ancienIdParcelle;

        return $this;
    }

    public function getNumeroVolume(): ?string
    {
        return $this->numeroVolume;
    }

    public function setNumeroVolume(?string $numeroVolume): self
    {
        $this->numeroVolume = $numeroVolume;

        return $this;
    }

    public function getLot1Numero(): ?string
    {
        return $this->lot1Numero;
    }

    public function setLot1Numero(?string $lot1Numero): self
    {
        $this->lot1Numero = $lot1Numero;

        return $this;
    }

    public function getLot1Surface(): ?string
    {
        return $this->lot1Surface;
    }

    public function setLot1Surface(?string $lot1Surface): self
    {
        $this->lot1Surface = $lot1Surface;

        return $this;
    }

    public function getLot2Numero(): ?string
    {
        return $this->lot2Numero;
    }

    public function setLot2Numero(?string $lot2Numero): self
    {
        $this->lot2Numero = $lot2Numero;

        return $this;
    }

    public function getLot2Surface(): ?string
    {
        return $this->lot2Surface;
    }

    public function setLot2Surface(?string $lot2Surface): self
    {
        $this->lot2Surface = $lot2Surface;

        return $this;
    }

    public function getLot3Numero(): ?string
    {
        return $this->lot3Numero;
    }

    public function setLot3Numero(?string $lot3Numero): self
    {
        $this->lot3Numero = $lot3Numero;

        return $this;
    }

    public function getLot3Surface(): ?string
    {
        return $this->lot3Surface;
    }

    public function setLot3Surface(?string $lot3Surface): self
    {
        $this->lot3Surface = $lot3Surface;

        return $this;
    }

    public function getLo4Numero(): ?string
    {
        return $this->lo4Numero;
    }

    public function setLo4Numero(?string $lo4Numero): self
    {
        $this->lo4Numero = $lo4Numero;

        return $this;
    }

    public function getLot4Surface(): ?string
    {
        return $this->lot4Surface;
    }

    public function setLot4Surface(?string $lot4Surface): self
    {
        $this->lot4Surface = $lot4Surface;

        return $this;
    }

    public function getLot5Numero(): ?string
    {
        return $this->lot5Numero;
    }

    public function setLot5Numero(?string $lot5Numero): self
    {
        $this->lot5Numero = $lot5Numero;

        return $this;
    }

    public function getLot5Surface(): ?string
    {
        return $this->lot5Surface;
    }

    public function setLot5Surface(?string $lot5Surface): self
    {
        $this->lot5Surface = $lot5Surface;

        return $this;
    }

    public function getNombreLots(): ?string
    {
        return $this->nombreLots;
    }

    public function setNombreLots(?string $nombreLots): self
    {
        $this->nombreLots = $nombreLots;

        return $this;
    }

    public function getCodeTypeLocal(): ?string
    {
        return $this->codeTypeLocal;
    }

    public function setCodeTypeLocal(?string $codeTypeLocal): self
    {
        $this->codeTypeLocal = $codeTypeLocal;

        return $this;
    }

    public function getTypeLocal(): ?string
    {
        return $this->typeLocal;
    }

    public function setTypeLocal(?string $typeLocal): self
    {
        $this->typeLocal = $typeLocal;

        return $this;
    }

    public function getSurfaceReelleBatiment(): ?string
    {
        return $this->surfaceReelleBatiment;
    }

    public function setSurfaceReelleBatiment(?string $surfaceReelleBatiment): self
    {
        $this->surfaceReelleBatiment = $surfaceReelleBatiment;

        return $this;
    }

    public function getNombrePiecesPrincipales(): ?string
    {
        return $this->nombrePiecesPrincipales;
    }

    public function setNombrePiecesPrincipales(?string $nombrePiecesPrincipales): self
    {
        $this->nombrePiecesPrincipales = $nombrePiecesPrincipales;

        return $this;
    }

    public function getCodeNatureCulture(): ?string
    {
        return $this->codeNatureCulture;
    }

    public function setCodeNatureCulture(?string $codeNatureCulture): self
    {
        $this->codeNatureCulture = $codeNatureCulture;

        return $this;
    }

    public function getNatureCulture(): ?string
    {
        return $this->natureCulture;
    }

    public function setNatureCulture(?string $natureCulture): self
    {
        $this->natureCulture = $natureCulture;

        return $this;
    }

    public function getCodeNatureCultureSpeciale(): ?string
    {
        return $this->codeNatureCultureSpeciale;
    }

    public function setCodeNatureCultureSpeciale(?string $codeNatureCultureSpeciale): self
    {
        $this->codeNatureCultureSpeciale = $codeNatureCultureSpeciale;

        return $this;
    }

    public function getNatureCultureSpeciale(): ?string
    {
        return $this->natureCultureSpeciale;
    }

    public function setNatureCultureSpeciale(?string $natureCultureSpeciale): self
    {
        $this->natureCultureSpeciale = $natureCultureSpeciale;

        return $this;
    }

    public function getSurfaceTerrain(): ?string
    {
        return $this->surfaceTerrain;
    }

    public function setSurfaceTerrain(?string $surfaceTerrain): self
    {
        $this->surfaceTerrain = $surfaceTerrain;

        return $this;
    }

    public function getLongitude(): ?string
    {
        return $this->longitude;
    }

    public function setLongitude(?string $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getLatitude(): ?string
    {
        return $this->latitude;
    }

    public function setLatitude(?string $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }
}
