<?php

namespace App\Controller;

use App\Repository\WorkoutRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    /**
     * @Route("/search", name="search")
     */
    public function index(Request $request, WorkoutRepository $workoutRepository): Response
    {
        $query = $request->query->get('search');

        $results = $workoutRepository->searchWorkoutByName($query);

        return $this->json(['workouts' => $results], Response::HTTP_OK, [], [
            'groups' => 'latest_workout'
        ]);
    }
}