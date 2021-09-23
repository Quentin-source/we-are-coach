<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\WorkoutRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function index(WorkoutRepository $workoutRepository, CategoryRepository $categoryRepository): Response
    {
    $categoryList = $categoryRepository->findAll();

    // We find the last 3 training sessions
    $latestWorkout = $workoutRepository->findBy([], ['id'=>'DESC'], 3); 
    
    // We send the result at the view
    return $this->render('home/index.html.twig', [
        'latestWorkout' => $latestWorkout,
        'categoryList' => $categoryList,
        ]);

    
    }
}
