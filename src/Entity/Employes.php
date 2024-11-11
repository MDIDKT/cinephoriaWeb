<?php

namespace App\Entity;

use App\Repository\EmployesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EmployesRepository::class)]
class Employes extends User
{
    /**
     * @var Collection<int, Incidents>
     */
    #[ORM\OneToMany(targetEntity: Incidents::class, mappedBy: 'employes')]
    private Collection $incident;

    public function __construct ()
    {
        $this->incident = new ArrayCollection();
    }

    /**
     * @return Collection<int, Incidents>
     */
    public function getIncident (): Collection
    {
        return $this->incident;
    }

    public function addIncident (Incidents $incident): static
    {
        if (!$this->incident->contains ($incident)) {
            $this->incident->add ($incident);
            $incident->setEmployes ($this);
        }

        return $this;
    }

    public function removeIncident (Incidents $incident): static
    {
        if ($this->incident->removeElement ($incident)) {
            // set the owning side to null (unless already changed)
            if ($incident->getEmployes () === $this) {
                $incident->setEmployes (null);
            }
        }

        return $this;
    }
}