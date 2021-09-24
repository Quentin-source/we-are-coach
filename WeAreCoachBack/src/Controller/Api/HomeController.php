<?php

namespace App\Controller\Api;

use App\Repository\CategoryRepository;
use App\Repository\WorkoutRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

    /**
     * @Route("/api/home", name="api_home_")
     */
class HomeController extends AbstractController
{
    /**
     * URL : /api/home/
     * Route : api_home_category
     * 
     * @Route("/category", name="category", methods={"GET"})
     */
    public function carousel_category(CategoryRepository $categoryRepository): Response
    {

        $categoryList = $categoryRepository->findAll();

        return $this->json($categoryList, 200, [], [

        'groups' => 'category_list'

        ]);

    }

    /**
     * 
     * @Route("/workout", name="workout", methods={"GET"})
     */
    public function carousel_workout(WorkoutRepository $workoutRepository): Response
    {


        // We find the last 3 training sessions
        $latestWorkout = $workoutRepository->findBy([], ['id'=>'DESC'], 3); 

        return $this->json($latestWorkout, 200, [], [

        'groups' => 'latest_workout'

        ]);

    }
}
