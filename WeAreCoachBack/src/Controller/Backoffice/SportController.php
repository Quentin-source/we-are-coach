<?php

namespace App\Controller\Backoffice;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Sport;
use App\Repository\SportRepository;

    /**
     * @Route("/backoffice/sport", name="backoffice_sport_")
     */

class SportController extends AbstractController
{
    /**
     * Show all categories from Admin 
     * 
     * @Route("/", name="index")
     */
    public function index(SportRepository $sportRepository): Response
    {
        return $this->render('backoffice/sport/index.html.twig', [
            'sports' => $sportRepository->findAll(),
        ]);
    }

}