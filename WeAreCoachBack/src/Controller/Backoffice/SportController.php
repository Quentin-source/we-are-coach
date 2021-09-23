<?php

namespace App\Controller\Backoffice;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SportController extends AbstractController
{
    /**
     * @Route("/backoffice/sport", name="backoffice_sport")
     */
    public function index(): Response
    {
        return $this->render('backoffice/sport/index.html.twig', [
            'controller_name' => 'SportController',
        ]);
    }
}
