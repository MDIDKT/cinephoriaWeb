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

    #[ORM\OneToMany(mappedBy: 'seances', targetEntity: Reservations::class)]
    private Collection $reservations;

    #[ORM\ManyToOne(inversedBy: 'seances')]
    private ?Films $films = null;

    #[ORM\ManyToOne(targetEntity: Salles::class, inversedBy: 'seances')]
    private ?Salles $salle = null;

    #[ORM\ManyToOne(inversedBy: 'seance')]
    private ?Cinemas $cinemas = null;

    public function __construct()
    {
        $this->reservations = new ArrayCollection();
        $this->heureDebut = new \DateTimeImmutable();
    }
}