<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: 'user')]
#[ORM\InheritanceType('SINGLE_TABLE')]
#[ORM\DiscriminatorColumn(name: 'type', type: 'string')]
#[ORM\DiscriminatorMap([
    'user' => User::class,
    'administrateur' => Administrateur::class,
    'employe' => Employes::class
])]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column]
    private bool $isVerified = false;

    /**
     * @var Collection<int, Reservations>
     */
    #[ORM\OneToMany(targetEntity: Reservations::class, mappedBy: 'user')]
    private Collection $reservations;

    /**
     * @var Collection<int, Avis>
     */
    #[ORM\OneToMany(targetEntity: Avis::class, mappedBy: 'user')]
    private Collection $avis;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    public function __construct ()
    {
        $this->reservations = new ArrayCollection();
        $this->avis = new ArrayCollection();
    }

    public function getId (): ?int
    {
        return $this->id;
    }

    public function getEmail (): ?string
    {
        return $this->email;
    }

    public function setEmail (string $email): static
    {
        $this->email = $email;
        return $this;
    }

    public function getUserIdentifier (): string
    {
        return (string)$this->email;
    }

    public function getRoles (): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';
        return array_unique ($roles);
    }

    public function setRoles (array $roles): static
    {
        $this->roles = $roles;
        return $this;
    }

    public function getPassword (): ?string
    {
        return $this->password;
    }

    public function setPassword (string $password): static
    {
        $this->password = $password;
        return $this;
    }

    public function eraseCredentials (): void
    {
        // Clear temporary or sensitive data
    }

    public function isVerified (): bool
    {
        return $this->isVerified;
    }

    public function setVerified (bool $isVerified): static
    {
        $this->isVerified = $isVerified;
        return $this;
    }

    /**
     * @return Collection<int, Reservations>
     */
    public function getReservations (): Collection
    {
        return $this->reservations;
    }

    public function addReservation (Reservations $reservation): static
    {
        if (!$this->reservations->contains ($reservation)) {
            $this->reservations->add ($reservation);
            $reservation->setUser ($this);
        }

        return $this;
    }

    public function removeReservation (Reservations $reservation): static
    {
        if ($this->reservations->removeElement ($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getUser () === $this) {
                $reservation->setUser (null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Avis>
     */
    public function getAvis (): Collection
    {
        return $this->avis;
    }

    public function addAvi (Avis $avi): static
    {
        if (!$this->avis->contains ($avi)) {
            $this->avis->add ($avi);
            $avi->setUser ($this);
        }

        return $this;
    }

    public function removeAvi (Avis $avi): static
    {
        if ($this->avis->removeElement ($avi)) {
            // set the owning side to null (unless already changed)
            if ($avi->getUser () === $this) {
                $avi->setUser (null);
            }
        }

        return $this;
    }

    public function getNom (): ?string
    {
        return $this->nom;
    }

    public function setNom (string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom (): ?string
    {
        return $this->prenom;
    }

    public function setPrenom (string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function __toString (): string
    {
        return $this->nom;
    }
}