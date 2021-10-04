<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FavoriteController extends AbstractController
{
    /**
     * @Route("/api/favorite", name="api_favorite")
     */
    public function index(): Response
    {
        return $this->render('api/favorite/index.html.twig', [
            'controller_name' => 'FavoriteController',
        ]);
    }
}
