<?php

namespace App\Entity;

use App\Repository\SallesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    /**
     * @var Collection<int, Incidents>
     */
    #[ORM\OneToMany(targetEntity: Incidents::class, mappedBy: 'salle')]
    private Collection $incidents;

    /**
     * @var Collection<int, Seance>
     */
    #[ORM\OneToMany(targetEntity: Seance::class, mappedBy: 'salle')]
    private Collection $seances;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $typeQualite = null;

    public function __construct ()
    {
        $this->incidents = new ArrayCollection();
        $this->seances = new ArrayCollection();
    }

    public function getId (): ?int
    {
        return $this->id;
    }

    public function getNumeroSalle (): ?int
    {
        return $this->numeroSalle;
    }

    public function setNumeroSalle (int $numeroSalle): static
    {
        $this->numeroSalle = $numeroSalle;

        return $this;
    }


    public function getNombreSiege (): ?int
    {
        return $this->nombreSiege;
    }

    public function setNombreSiege (int $nombreSiege): static
    {
        $this->nombreSiege = $nombreSiege;

        return $this;
    }

    public function getNombreSiegePMR (): ?int
    {
        return $this->nombreSiegePMR;
    }

    public function setNombreSiegePMR (int $nombreSiegePMR): static
    {
        $this->nombreSiegePMR = $nombreSiegePMR;

        return $this;
    }

    /**
     * @return Collection<int, Incidents>
     */
    public function getIncidents (): Collection
    {
        return $this->incidents;
    }

    public function addIncident (Incidents $incident): static
    {
        if (!$this->incidents->contains ($incident)) {
            $this->incidents->add ($incident);
            $incident->setSalle ($this);
        }

        return $this;
    }

    public function removeIncident (Incidents $incident): static
    {
        if ($this->incidents->removeElement ($incident)) {
            // set the owning side to null (unless already changed)
            if ($incident->getSalle () === $this) {
                $incident->setSalle (null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Seance>
     */
    public function getSeances (): Collection
    {
        return $this->seances;
    }

    public function addSeance (Seance $seance): static
    {
        if (!$this->seances->contains ($seance)) {
            $this->seances->add ($seance);
            $seance->setSalle ($this);
        }

        return $this;
    }

    public function removeSeance (Seance $seance): static
    {
        if ($this->seances->removeElement ($seance)) {
            // set the owning side to null (unless already changed)
            if ($seance->getSalle () === $this) {
                $seance->setSalle (null);
            }
        }

        return $this;
    }

    public function getTypeQualite (): ?string
    {
        return $this->typeQualite;
    }

    public function setTypeQualite (?string $typeQualite): static
    {
        $this->typeQualite = $typeQualite;

        return $this;
    }

}
