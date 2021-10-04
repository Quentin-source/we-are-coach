<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    /**
     * @Route("/api/category", name="api_category")
     */
    public function index(): Response
    {
        return $this->render('api/category/index.html.twig', [
            'controller_name' => 'CategoryController',
        ]);
    }
}
