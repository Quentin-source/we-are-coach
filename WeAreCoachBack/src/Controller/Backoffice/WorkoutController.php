<?php

namespace App\Controller\Backoffice;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Workout;
use App\Repository\WorkoutRepository;

    /**
     * @Route("/backoffice/workout", name="backoffice_workout_")
     */

class WorkoutController extends AbstractController
{
    /**
     * Show all categories from Admin 
     * 
     * @Route("/", name="index")
     */
    public function index(WorkoutRepository $workoutRepository): Response
    {
        return $this->render('backoffice/workout/index.html.twig', [
            'workouts' => $workoutRepository->findAll(),
        ]);
    }

}