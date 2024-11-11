<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\FilmsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: FilmsRepository::class)]
#[Vich\Uploadable]
#[ApiResource]
class Films
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column]
    private ?int $ageMinimum = null;

    #[ORM\Column]
    private ?bool $coupDeCoeur = null;

    #[ORM\Column]
    private ?float $note = null;

    #[ORM\OneToMany(targetEntity: Seance::class, mappedBy: 'films')]
    private Collection $seances;

    #[ORM\Column(length: 255)]
    private ?string $qualite = null;

    #[ORM\OneToMany(targetEntity: Reservations::class, mappedBy: 'films')]
    private Collection $reservations;

    #[Vich\UploadableField(mapping: 'affiche', fileNameProperty: 'imageName', size: 'imageSize')]
    private ?File $imageFile = null;

    #[ORM\Column(nullable: true)]
    private ?string $imageName = null;

    #[ORM\Column(nullable: true)]
    private ?int $imageSize = null;

    #[ORM\OneToMany(targetEntity: Avis::class, mappedBy: 'film')]
    private Collection $avis;

    /**
     * @var Collection<int, Cinemas>
     */
    #[ORM\ManyToMany(targetEntity: Cinemas::class, mappedBy: 'film')]
    private Collection $cinemas;

    public function __construct ()
    {
        $this->seances = new ArrayCollection();
        $this->reservations = new ArrayCollection();
        $this->avis = new ArrayCollection();
        $this->cinemas = new ArrayCollection();
    }

    public function getId (): ?int
    {
        return $this->id;
    }

    public function getTitre (): ?string
    {
        return $this->titre;
    }

    public function setTitre (string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDescription (): ?string
    {
        return $this->description;
    }

    public function setDescription (string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getAgeMinimum (): ?int
    {
        return $this->ageMinimum;
    }

    public function setAgeMinimum (int $ageMinimum): static
    {
        $this->ageMinimum = $ageMinimum;

        return $this;
    }

    public function isCoupDeCoeur (): ?bool
    {
        return $this->coupDeCoeur;
    }

    public function setCoupDeCoeur (bool $coupDeCoeur): static
    {
        $this->coupDeCoeur = $coupDeCoeur;

        return $this;
    }

    public function getNote (): ?float
    {
        return $this->note;
    }

    public function setNote (float $note): static
    {
        $this->note = $note;

        return $this;
    }

    public function getSeances (): Collection
    {
        return $this->seances;
    }

    public function addSeance (Seance $seance): static
    {
        if (!$this->seances->contains ($seance)) {
            $this->seances->add ($seance);
            $seance->setFilms ($this);
        }

        return $this;
    }

    public function removeSeance (Seance $seance): static
    {
        if ($this->seances->removeElement ($seance) && $seance->getFilms () === $this) {
            $seance->setFilms (null);
        }

        return $this;
    }

    public function getQualite (): ?string
    {
        return $this->qualite;
    }

    public function setQualite (string $qualite): static
    {
        $this->qualite = $qualite;

        return $this;
    }

    public function getReservations (): Collection
    {
        return $this->reservations;
    }

    public function addReservation (Reservations $reservation): static
    {
        if (!$this->reservations->contains ($reservation)) {
            $this->reservations->add ($reservation);
            $reservation->setFilms ($this);
        }

        return $this;
    }

    public function removeReservation (Reservations $reservation): static
    {
        if ($this->reservations->removeElement ($reservation) && $reservation->getFilms () === $this) {
            $reservation->setFilms (null);
        }

        return $this;
    }

    public function getImageFile (): ?File
    {
        return $this->imageFile;
    }

    public function setImageFile (?File $imageFile): void
    {
        $this->imageFile = $imageFile;
    }

    public function getImageName (): ?string
    {
        return $this->imageName;
    }

    public function setImageName (?string $imageName): void
    {
        $this->imageName = $imageName;
    }

    public function getImageSize (): ?int
    {
        return $this->imageSize;
    }

    public function setImageSize (?int $imageSize): void
    {
        $this->imageSize = $imageSize;
    }

    public function __toString (): string
    {
        return $this->titre;
    }

    public function getAvis (): Collection
    {
        return $this->avis;
    }

    public function addAvis (Avis $avis): static
    {
        if (!$this->avis->contains ($avis)) {
            $this->avis->add ($avis);
            $avis->setFilm ($this);
        }

        return $this;
    }

    public function removeAvis (Avis $avis): static
    {
        if ($this->avis->removeElement ($avis) && $avis->getFilm () === $this) {
            $avis->setFilm (null);
        }

        return $this;
    }

    /**
     * @return Collection<int, Cinemas>
     */
    public function getCinemas (): Collection
    {
        return $this->cinemas;
    }

    public function addCinema (Cinemas $cinema): static
    {
        if (!$this->cinemas->contains ($cinema)) {
            $this->cinemas->add ($cinema);
            $cinema->addFilm ($this);
        }

        return $this;
    }

    public function removeCinema (Cinemas $cinema): static
    {
        if ($this->cinemas->removeElement ($cinema)) {
            $cinema->removeFilm ($this);
        }

        return $this;
    }
}