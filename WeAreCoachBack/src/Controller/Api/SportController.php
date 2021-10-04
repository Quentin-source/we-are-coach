<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SportController extends AbstractController
{
    /**
     * @Route("/api/sport", name="api_sport")
     */
    public function index(): Response
    {
        return $this->render('api/sport/index.html.twig', [
            'controller_name' => 'SportController',
        ]);
    }
}
