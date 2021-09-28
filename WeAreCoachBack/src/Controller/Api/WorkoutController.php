<?php

namespace App\Controller\Api;

use App\Repository\WorkoutRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


    /**
     * @Route("/api/workout", name="api_workout_")
     */
class WorkoutController extends AbstractController
{
    /**
     * @Route("/", name="workout", methods={"GET"})
     */
    public function index(WorkoutRepository $workoutRepository): Response
    {

        $workoutList = $workoutRepository->findAll();

        return $this->json($workoutList, 200, [], [
            'groups' => 'workout_list'
        ]);
    }
}
