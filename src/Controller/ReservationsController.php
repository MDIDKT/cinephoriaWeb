<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Reservations;
use App\Form\ReservationsType;
use App\Repository\ReservationsRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/reservations')]
final class ReservationsController extends AbstractController
{
    #[Route('/index', name: 'app_reservations_index', methods: ['GET'])]
    public function index(ReservationsRepository $reservationsRepository): Response
    {
        return $this->render('reservations/index.html.twig', [
            'reservations' => $reservationsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_reservations_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $reservation = new Reservations();
        $reservation->setDate(new DateTimeImmutable());
        $form = $this->createForm(ReservationsType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            return $this->processReservation($reservation, $entityManager, 'reservations/new.html.twig');
        }

        return $this->render('reservations/new.html.twig', [
            'reservation' => $reservation,
            'form' => $form,
        ]);
    }

    private function processReservation(Reservations $reservation, EntityManagerInterface $entityManager, string $view): Response
    {
        $seance = $reservation->getSeances();

        // Vérifie que la séance est valable
        if ($seance === null || $seance->getSalle() === null) {
            $this->addFlash('error', 'Séance ou salle invalide pour cette réservation.');
            return $this->render($view, [
                'reservation' => $reservation,
                'form' => $this->createForm(ReservationsType::class, $reservation)->createView(),
            ]);
        }

        $salle = $seance->getSalle();
        $requestedSeats = $reservation->getNombrePlaces();

        if ($requestedSeats <= 0) {
            $this->addFlash('error', 'Le nombre de places doit être supérieur à 0.');
            return $this->render($view, [
                'reservation' => $reservation,
                'form' => $this->createForm(ReservationsType::class, $reservation)->createView(),
            ]);
        }

        if ($requestedSeats > $salle->getNombrePlacesDisponibles()) {
            $this->addFlash('error', 'Pas assez de places disponibles.');
            return $this->render($view, [
                'reservation' => $reservation,
                'form' => $this->createForm(ReservationsType::class, $reservation)->createView(),
            ]);
        }

        // Réduction des places disponibles dans la salle
        $salle->reservePlaces($requestedSeats);

        // Calcul du prix total
        $reservation->setPrixTotal($reservation->calculprixTotal());

        $entityManager->persist($salle);
        $entityManager->persist($reservation);
        $entityManager->flush();

        $this->addFlash('success', 'Réservation effectuée avec succès.');

        return $this->redirectToRoute('app_reservations_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}', name: 'app_reservations_show', methods: ['GET'])]
    public function show(?Reservations $reservation): Response
    {
        if ($reservation === null) {
            throw $this->createNotFoundException('Réservation non trouvée.');
        }

        return $this->render('reservations/show.html.twig', [
            'reservation' => $reservation,
            'films' => $reservation->getFilms(),
        ]);
    }

    #[Route('/{id}/edit', name: 'app_reservations_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Reservations $reservation, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ReservationsType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $initialReservedSeats = $reservation->getNombrePlaces();
            $salle = $reservation->getSeances()->getSalle();

            if ($salle !== null) {
                // Rétablir les places initiales
                $salle->libererPlaces($initialReservedSeats);

                // Appliquer les nouvelles réservations
                $newRequestedSeats = $reservation->getNombrePlaces();
                if ($newRequestedSeats > $salle->getNombrePlacesDisponibles()) {
                    $this->addFlash('error', 'Pas assez de places disponibles.');
                    return $this->render('reservations/edit.html.twig', [
                        'reservation' => $reservation,
                        'form' => $form->createView(),
                    ]);
                }

                $salle->reservePlaces($newRequestedSeats);
                $reservation->setPrixTotal($reservation->calculprixTotal());

                $entityManager->persist($salle);
                $entityManager->persist($reservation);
                $entityManager->flush();

                $this->addFlash('success', 'Réservation modifiée avec succès.');
                return $this->redirectToRoute('app_reservations_index');
            }
        }

        return $this->render('reservations/edit.html.twig', [
            'reservation' => $reservation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_reservations_delete', methods: ['POST'])]
    public function delete(Request $request, Reservations $reservation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $reservation->getId(), $request->request->get('_token'))) {
            $salle = $reservation->getSeances()->getSalle();

            if ($salle !== null) {
                $salle->libererPlaces($reservation->getNombrePlaces());
                $entityManager->persist($salle);
            }

            $entityManager->remove($reservation);
            $entityManager->flush();

            $this->addFlash('success', 'Réservation supprimée avec succès.');
        }

        return $this->redirectToRoute('app_reservations_index', [], Response::HTTP_SEE_OTHER);
    }
}