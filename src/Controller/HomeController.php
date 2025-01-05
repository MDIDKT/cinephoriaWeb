<?php

namespace App\Controller;

use App\Entity\Films;
use App\Repository\FilmsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index (FilmsRepository $filmsRepository): Response
    {
        $films = $filmsRepository->findAll ();
        return $this->render ('home/index.html.twig', [
            'filmsLast' => $filmsRepository->find3LastFilms (),
        ]);
    }

    #[Route('/films/{id}', name: 'app_home_show', methods: ['GET'])]
    public function show (Films $film): Response
    {
        // Ajouter la colonne 'updated_at' dans la requête
        $film->getUpdatedAt();
        return $this->render ('films/show.html.twig', [
            'film' => $film,
        ]);
    }
}
