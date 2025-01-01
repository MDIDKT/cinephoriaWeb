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
    private ?string $titre = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column]
    private ?int $ageMinimum = null;

    #[ORM\Column]
    private ?bool $coupDeCoeur = null;

    #[ORM\Column]
    private ?float $note = null;

    #[ORM\OneToMany(mappedBy: 'films', targetEntity: Seance::class)]
    private Collection $seances;

    #[ORM\Column(length: 255)]
    private ?string $qualite = null;

    #[ORM\OneToMany(mappedBy: 'films', targetEntity: Reservations::class)]
    private Collection $reservations;

    #[Vich\UploadableField(mapping: 'affiche', fileNameProperty: 'imageName', size: 'imageSize')]
    private ?File $imageFile = null;

    #[ORM\Column(nullable: true)]
    private ?string $imageName = null;

    #[ORM\Column(nullable: true)]
    private ?int $imageSize = null;

    #[ORM\OneToMany(mappedBy: 'film', targetEntity: Avis::class)]
    private Collection $avis;

    #[ORM\ManyToMany(targetEntity: Cinemas::class, inversedBy: 'film')]
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

    public function getSeances(): Collection
    {
        return $this->seances;
    }

    public function getCinemas(): Collection
    {
        return $this->cinemas;
    }

    public function addCinema(Cinemas $cinema): self
    {
        if (!$this->cinemas->contains($cinema)) {
            $this->cinemas->add($cinema);
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