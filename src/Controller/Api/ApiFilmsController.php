<?php

// src/Controller/Api/FilmController.php
namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ApiFilmsController extends AbstractController
{
#[Route('/api/films', name: 'api_films', methods: ['GET'])]
public function listFilms(): JsonResponse
{
$films = [
['id' => 1, 'title' => 'Film 1', 'description' => 'Description du film 1'],
['id' => 2, 'title' => 'Film 2', 'description' => 'Description du film 2'],
];

return $this->json($films);
}
}
