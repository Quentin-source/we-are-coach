<?php

namespace App\Controller\Backoffice;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WorkoutController extends AbstractController
{
    /**
     * @Route("/backoffice/workout", name="backoffice_workout")
     */
    public function index(): Response
    {
        return $this->render('backoffice/workout/index.html.twig', [
            'controller_name' => 'WorkoutController',
        ]);
    }
}
