<?php

namespace App\Entity;

use App\Repository\SallesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SallesRepository::class)]
class Salles
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $numeroSalle = null;

    #[ORM\Column]
    private ?int $nombreSiege = null;

    #[ORM\Column]
    private ?int $nombreSiegePMR = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumeroSalle(): ?int
    {
        return $this->numeroSalle;
    }

    public function setNumeroSalle(int $numeroSalle): static
    {
        $this->numeroSalle = $numeroSalle;

        return $this;
    }


    public function getNombreSiege(): ?int
    {
        return $this->nombreSiege;
    }

    public function setNombreSiege(int $nombreSiege): static
    {
        $this->nombreSiege = $nombreSiege;

        return $this;
    }

    public function getNombreSiegePMR(): ?int
    {
        return $this->nombreSiegePMR;
    }

    public function setNombreSiegePMR(int $nombreSiegePMR): static
    {
        $this->nombreSiegePMR = $nombreSiegePMR;

        return $this;
    }


}
