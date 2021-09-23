<?php

namespace App\Controller\Backoffice;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategorieController extends AbstractController
{
    /**
     * @Route("/backoffice/categorie", name="backoffice_categorie")
     */
    public function index(): Response
    {
        return $this->render('backoffice/categorie/index.html.twig', [
            'controller_name' => 'CategorieController',
        ]);
    }
}
