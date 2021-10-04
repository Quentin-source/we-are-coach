<?php

namespace App\Controller\Api;

use App\Repository\WorkoutRepository;
use App\Repository\SportRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    /**
     * @Route("api/search", name="search")
     */
    public function workout(Request $request, WorkoutRepository $workoutRepository, SportRepository $sportRepository): Response
    {
        $query = $request->query->get('search');

        $resultsWorkout = $workoutRepository->searchWorkoutByName($query);
        $resultsSport = $sportRepository->searchSportByName($query);

        return $this->json(['workouts' => $resultsWorkout, 'sports' => $resultsSport], Response::HTTP_OK, [], [
            'groups' => ['workout_detail','sport_detail']
          
          
        ]);
    }


}