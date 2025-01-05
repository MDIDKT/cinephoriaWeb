<?php

namespace App\Entity;

use App\Repository\SeanceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SeanceRepository::class)]
class Seance
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $heureDebut = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $heureFin = null;

    #[ORM\OneToMany(mappedBy: 'seances', targetEntity: Reservations::class)]
    private Collection $reservations;

    #[ORM\ManyToOne(inversedBy: 'seances')]
    private ?Films $films = null;

    #[ORM\ManyToOne(targetEntity: Salles::class, inversedBy: "seances")]
    private ?Salles $salle = null;

    #[ORM\ManyToOne(inversedBy: 'seance')]
    private ?Cinemas $cinemas = null;



    public function __construct()
    {
        $this->reservations = new ArrayCollection();
        $this->heureDebut = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHeureDebut(): ?\DateTimeImmutable
    {
        return $this->heureDebut;
    }

    public function setHeureDebut(\DateTimeImmutable $heureDebut): static
    {
        $this->heureDebut = $heureDebut;

        return $this;
    }

    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addReservation(Reservations $reservation): static
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations->add($reservation);
            $reservation->setSeances($this);
        }

        return $this;
    }

    public function removeReservation(Reservations $reservation): static
    {
        if ($this->reservations->removeElement($reservation)) {
            if ($reservation->getSeances() === $this) {
                $reservation->setSeances(null);
            }
        }

        return $this;
    }

    public function getFilms(): ?Films
    {
        return $this->films;
    }

    public function setFilms(?Films $films): static
    {
        $this->films = $films;

        return $this;
    }

    public function getSalle(): ?Salles
    {
        // Vérifie si la salle est définie et la retourne.
        return $this->salle;
    }

    public function setSalle(?Salles $salle): static
    {
        $this->salle = $salle;

        return $this;
    }

    public function getCinemas(): ?Cinemas
    {
        return $this->cinemas;
    }

    public function setCinemas(?Cinemas $cinemas): static
    {
        $this->cinemas = $cinemas;

        return $this;
    }

    public function getPlacesDisponibles(): int
    {
        $salle = $this->getSalle();

        // Définit une valeur par défaut pour éviter une exception.
        if ($salle === null) {
            return 0;
        }

        $nombrePlacesTotales = $salle->getNombreSiege();
        $nombrePlacesReserves = count($this->getReservations());

        return max(0, $nombrePlacesTotales - $nombrePlacesReserves); // Ne retourne jamais un nombre négatif.
    }

    public function __toString(): string
    {
        $film = $this->getFilms()?->getTitre() ?? 'Film non défini';
        $heureDebut = $this->getHeureDebut()?->format('H:i') ?? 'Non défini';

        return sprintf('%s (%s)', $film, $heureDebut);
    }

    public function getHeureFin(): ?\DateTimeImmutable
    {
        return $this->heureFin;
    }

    public function setHeureFin(?\DateTimeImmutable $heureFin): void
    {
        $this->heureFin = $heureFin;
    }

}