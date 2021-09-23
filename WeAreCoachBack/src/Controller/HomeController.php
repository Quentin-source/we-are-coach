<?php

namespace App\Controller;

use App\Repository\WorkoutRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function index(WorkoutRepository $workoutRepository): Response
    {

    $latestWorkout = $workoutRepository->findBy([], ['id'=>'DESC'], 3); 

    return $this->render('home/index.html.twig', [
        'latestWorkout' => $latestWorkout,
        ]);

    
    }
}
