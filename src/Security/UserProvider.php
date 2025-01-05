<?php

namespace App\Security;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;

class UserProvider implements UserProviderInterface
{
    private EntityManagerInterface $entityManager;

    public function __construct (EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    // Nouvelle méthode à ajouter pour respecter l'interface
    public function loadUserByIdentifier (string $identifier): UserInterface
    {
        $user = $this->entityManager->getRepository (User::class)->findOneBy (['email' => $identifier]);

        if (!$user) {
            throw new UserNotFoundException(sprintf ('User "%s" not found.', $identifier));
        }

        return $user;
    }

    public function refreshUser (UserInterface $user): UserInterface
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf ('Instances of "%s" are not supported.', get_class ($user)));
        }

        return $this->entityManager->getRepository (User::class)->find ($user->getId ());
    }

    public function supportsClass (string $class): bool
    {
        return User::class === $class;
    }
}
