<?php

namespace App\Controller;

use App\Repository\WorkoutRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WorkoutController extends AbstractController
{
    /**
     * @Route("/workout", name="workout")
     */
    public function index(WorkoutRepository $workoutRepository): Response
    {

        $workoutList = $workoutRepository->findAll();
        return $this->render('workout/index.html.twig', [
        'workoutList' => $workoutList,
        ]);
    }
}
