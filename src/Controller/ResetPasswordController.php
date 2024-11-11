<?php

namespace App\Controller;

use App\Form\ResetPasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class ResetPasswordController extends AbstractController
{
    #[Route('/reset/password', name: 'app_reset_password')]
    public function resetPassword (
        string                      $token,
        Request                     $request,
        UserPasswordHasherInterface $passwordHasher,
        EntityManagerInterface      $entityManager
    ): Response
    {
        $user = $entityManager->getRepository (Entity::class)->findOneBy ([
            'resetToken' => $token,
        ]);
        if (!$user) {
            $this->addFlash ('error', 'Token Inconnu');
            return $this->redirectToRoute ('app_login');
        }
        $form = $this->createForm (ResetPasswordType::class);
        $form->handleRequest ($request);

        if ($form->isSubmitted () && $form->isValid ()) {
            // Récupération du nouveau mot de passe
            $newPassword = $form->get ('plainPassword')->getData ();

            // Hashage du mot de passe
            $hashedPassword = $passwordHasher->hashPassword ($user, $newPassword);
            $user->setPassword ($hashedPassword);

            // Suppression du token de réinitialisation pour des raisons de sécurité
            $user->setResetToken (null);

            // Sauvegarder les modifications en base de données
            $entityManager->flush ();

            // Message de succès et redirection
            $this->addFlash ('success', 'Votre mot de passe a bien été réinitialisé.');
            return $this->redirectToRoute ('app_login');
        }
        return $this->render ('reset_password/index.html.twig', [
            'resetPasswordForm' => $form->createView (),
        ]);
    }
}
