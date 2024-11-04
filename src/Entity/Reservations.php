<?php

namespace App\Entity;

use App\Repository\ReservationsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReservationsRepository::class)]
class Reservations
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'reservations')]
    private ?Cinemas $cinemas = null;
    #[ORM\ManyToOne(inversedBy: 'reservations')]
    private ?Seance $seances = null;

    #[ORM\Column]
    private ?int $nombrePlaces = null;

    #[ORM\Column]
    private ?bool $typePMR = null;

    #[ORM\Column]
    private ?float $prixTotal;

    #[ORM\ManyToOne(inversedBy: 'reservations')]
    private ?Films $films = null;

    public function __construct ()
    {
        $this->prixTotal = $this->getNombrePlaces () * 8;
    }

    public function getId (): ?int
    {
        return $this->id;
    }

    public function getCinemas (): ?Cinemas
    {
        return $this->cinemas;
    }

    public function setCinemas (?Cinemas $cinemas): static
    {
        $this->cinemas = $cinemas;

        return $this;
    }

    public function getSeances (): ?Seance
    {
        return $this->seances;
    }

    public function setSeances (?Seance $seances): static
    {
        $this->seances = $seances;

        return $this;
    }

    public function getNombrePlaces (): ?int
    {
        return $this->nombrePlaces;
    }

    public function setNombrePlaces (int $nombrePlaces): static
    {
        $this->nombrePlaces = $nombrePlaces;

        return $this;
    }

    public function isTypePMR (): ?bool
    {
        return $this->typePMR;
    }

    public function setTypePMR (bool $typePMR): static
    {
        $this->typePMR = $typePMR;

        return $this;
    }

    public function getPrixTotal (): ?float
    {
        return $this->prixTotal = $this->getNombrePlaces () * 8 + $this->isTypePMR ($this->typePMR * 5 / 100);
    }

    public function setPrixTotal (float $prixTotal): static
    {
        $this->prixTotal = $prixTotal;

        return $this;
    }

    public function getFilms (): ?Films
    {
        return $this->films;
    }

    public function setFilms (?Films $films): static
    {
        $this->films = $films;

        return $this;
    }

    public function __toString (): string
    {
        return $this->getNombrePlaces ();
    }

}
