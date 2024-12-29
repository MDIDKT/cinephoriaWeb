<?php

namespace App\Entity;

use App\Repository\SallesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

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
    #[Assert\Positive(message: 'Le nombre de sièges doit être supérieur à 0.')]
    private ?int $nombreSiege = null;

    #[ORM\Column(nullable: true)]
    #[Assert\PositiveOrZero(message: 'Le nombre de sièges PMR doit être supérieur ou égal à 0.')]
    private ?int $nombreSiegePMR = null;

    #[ORM\Column(type: 'integer')]
    private ?int $nombrePlacesDisponibles = null;

    public function __construct()
    {
        $this->incidents = new ArrayCollection();
        $this->seances = new ArrayCollection();
    }

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

        // Toutes les places disponibles sont libres par défaut
        $this->nombrePlacesDisponibles = $nombreSiege;

        return $this;
    }

    public function reservePlaces(int $nombrePlaces): void
    {
        if ($this->nombrePlacesDisponibles < $nombrePlaces) {
            throw new \InvalidArgumentException('Il n\'y a pas assez de places disponibles.');
        }

        $this->nombrePlacesDisponibles -= $nombrePlaces;
    }

    public function libererPlaces(int $nombrePlaces): void
    {
        $this->nombrePlacesDisponibles += $nombrePlaces;

        // Empêche une incohérence
        if ($this->nombrePlacesDisponibles > $this->nombreSiege) {
            $this->nombrePlacesDisponibles = $this->nombreSiege;
        }
    }
    public function getNombreSiegePMR(): ?int
    {
        return $this->nombreSiegePMR;
    }

    public function setNombreSiegePMR(?int $nombreSiegePMR): static
    {
        $this->nombreSiegePMR = $nombreSiegePMR;

        // Assure que le total est toujours synchronisé
        if ($this->nombreSiege !== null) {
            $this->nombrePlacesDisponibles = max(0, $this->nombreSiege - $this->nombreSiegePMR);
        }

        return $this;
    }

    public function getNombrePlacesDisponibles(): ?int
    {
        return $this->nombrePlacesDisponibles;
    }

    public function setNombrePlacesDisponibles(int $nombrePlacesDisponibles): static
    {
        // Validation : vérifier que les places disponibles restent cohérentes
        if ($this->nombreSiege !== null && $this->nombreSiegePMR !== null) {
            $maxPlaces = $this->nombreSiege - $this->nombreSiegePMR;
            if ($nombrePlacesDisponibles > $maxPlaces) {
                throw new \InvalidArgumentException('Le nombre de places disponibles ne peut pas dépasser le total disponible.');
            }
        }

        $this->nombrePlacesDisponibles = $nombrePlacesDisponibles;

        return $this;
    }

    #[Assert\Callback]
    public function validateNombreSiegeTotal(ExecutionContextInterface $context): void
    {
        // Validation en dernier recours
        if (
            $this->nombreSiege !== null &&
            $this->nombreSiegePMR !== null &&
            $this->nombrePlacesDisponibles !== null
        ) {
            if ($this->nombreSiege !== $this->nombreSiegePMR + $this->nombrePlacesDisponibles) {
                $context->buildViolation('Le nombre total de sièges doit être égal au nombre de sièges PMR + places disponibles.')
                    ->atPath('nombreSiege')
                    ->addViolation();
            }
        }
    }

    public function __toString(): string
    {
        return sprintf('Salle %d', $this->numeroSalle);
    }
}