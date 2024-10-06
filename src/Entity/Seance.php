<?php

namespace App\Entity;

use App\Repository\SeanceRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SeanceRepository::class)]
class Seance
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $HeureDebut = null;

    #[ORM\ManyToOne(inversedBy: 'seances')]
    private ?Films $film = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHeureDebut(): ?\DateTimeImmutable
    {
        return $this->HeureDebut;
    }

    public function setHeureDebut(\DateTimeImmutable $HeureDebut): static
    {
        $this->HeureDebut = $HeureDebut;

        return $this;
    }

    public function getFilm(): ?Films
    {
        return $this->film;
    }

    public function setFilm(?Films $film): static
    {
        $this->film = $film;

        return $this;
    }
}
