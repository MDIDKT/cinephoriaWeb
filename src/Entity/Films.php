<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\FilmsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
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
    #[Assert\NotBlank(message: 'Le titre est obligatoire.')]
    #[Assert\Length(max: 255, maxMessage: 'Le titre ne peut pas dépasser 255 caractères.')]
    private ?string $titre = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank(message: 'La description est obligatoire.')]
    private ?string $description = null;

    #[ORM\Column]
    #[Assert\NotNull(message: 'L’âge minimum est obligatoire.')]
    #[Assert\Range(
        min: 0,
        max: 100,
        notInRangeMessage: 'L’âge minimum doit être compris entre {{ min }} et {{ max }} ans.',
    )]
    private ?int $ageMinimum = null;

    #[ORM\Column]
    #[Assert\NotNull(message: 'Le champ "Coup de Cœur" est obligatoire.')]
    private ?bool $coupDeCoeur = null;

    #[ORM\Column]
    #[Assert\Range(
        min: 0,
        max: 10,
        notInRangeMessage: 'La note doit être comprise entre {{ min }} et {{ max }}.',
    )]
    private ?float $note = null;

    #[ORM\OneToMany(targetEntity: Seance::class, mappedBy: 'films', cascade: ['persist', 'remove'])]
    private Collection $seances;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'La qualité est obligatoire.')]
    private ?string $qualite = null;

    #[ORM\OneToMany(targetEntity: Reservations::class, mappedBy: 'films', cascade: ['persist', 'remove'])]
    private Collection $reservations;

    // Gère les fichiers avec VichUploaderBundle
    #[Vich\UploadableField(mapping: 'affiche', fileNameProperty: 'imageName', size: 'imageSize')]
    #[Assert\File(
        maxSize: '2M',
        mimeTypes: ['image/jpeg', 'image/png'],
        mimeTypesMessage: 'L’affiche doit être une image valide (JPEG ou PNG).',
    )]
    private ?File $imageFile = null;

    #[ORM\Column(nullable: true)]
    private ?string $imageName = null;

    #[ORM\Column(nullable: true)]
    private ?int $imageSize = null;

    #[ORM\OneToMany(targetEntity: Avis::class, mappedBy: 'film', cascade: ['persist', 'remove'])]
    private Collection $avis;

    #[ORM\ManyToMany(targetEntity: Cinemas::class, inversedBy: 'films')]
    #[Assert\Count(
        min: 1,
        minMessage: 'Un film doit être associé à au moins un cinéma.',
    )]
    private Collection $cinemas;

    public function __construct()
    {
        $this->seances = new ArrayCollection();
        $this->reservations = new ArrayCollection();
        $this->avis = new ArrayCollection();
        $this->cinemas = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

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

    public function getAgeMinimum(): ?int
    {
        return $this->ageMinimum;
    }

    public function setAgeMinimum(int $ageMinimum): self
    {
        $this->ageMinimum = $ageMinimum;

        return $this;
    }

    public function isCoupDeCoeur(): ?bool
    {
        return $this->coupDeCoeur;
    }

    public function setCoupDeCoeur(bool $coupDeCoeur): self
    {
        $this->coupDeCoeur = $coupDeCoeur;

        return $this;
    }

    public function getNote(): ?float
    {
        return $this->note;
    }

    public function setNote(float $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getSeances(): Collection
    {
        return $this->seances;
    }

    public function addSeance(Seance $seance): self
    {
        if (!$this->seances->contains($seance)) {
            $this->seances[] = $seance;
            $seance->setFilms($this);
        }

        return $this;
    }

    public function removeSeance(Seance $seance): self
    {
        if ($this->seances->removeElement($seance)) {
            // dissocier le film de la séance supprimée
            if ($seance->getFilms() === $this) {
                $seance->setFilms(null);
            }
        }

        return $this;
    }

    public function getQualite(): ?string
    {
        return $this->qualite;
    }

    public function setQualite(string $qualite): self
    {
        $this->qualite = $qualite;

        return $this;
    }

    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addReservation(Reservations $reservation): self
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations[] = $reservation;
            $reservation->setFilms($this);
        }

        return $this;
    }

    public function removeReservation(Reservations $reservation): self
    {
        if ($this->reservations->removeElement($reservation)) {
            if ($reservation->getFilms() === $this) {
                $reservation->setFilms(null);
            }
        }

        return $this;
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageFile(?File $imageFile): void
    {
        $this->imageFile = $imageFile;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function setImageName(?string $imageName): void
    {
        $this->imageName = $imageName;
    }

    public function getImageSize(): ?int
    {
        return $this->imageSize;
    }

    public function setImageSize(?int $imageSize): void
    {
        $this->imageSize = $imageSize;
    }

    public function __toString(): string
    {
        return $this->titre;
    }

    public function getAvis(): Collection
    {
        return $this->avis;
    }

    public function addAvis(Avis $avis): self
    {
        if (!$this->avis->contains($avis)) {
            $this->avis[] = $avis;
            $avis->setFilm($this);
        }

        return $this;
    }

    public function removeAvis(Avis $avis): self
    {
        if ($this->avis->removeElement($avis)) {
            if ($avis->getFilm() === $this) {
                $avis->setFilm(null);
            }
        }

        return $this;
    }

    public function getCinemas(): Collection
    {
        return $this->cinemas;
    }

    public function addCinema(Cinemas $cinema): self
    {
        if (!$this->cinemas->contains($cinema)) {
            $this->cinemas[] = $cinema;
            $cinema->addFilm($this);
        }

        return $this;
    }

    public function removeCinema(Cinemas $cinema): self
    {
        if ($this->cinemas->removeElement($cinema)) {
            $cinema->removeFilm($this);
        }

        return $this;
    }
}