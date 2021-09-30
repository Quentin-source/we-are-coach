<?php

namespace App\Controller\Backoffice;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Category;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Service\ImageUploader;
use App\Form\CategoryType;

    /**
     * @Route("/backoffice/category", name="backoffice_category_")
     */

class CategoryController extends AbstractController
{
    /**
     * Show all categories from Admin
     *
     * @Route("/", name="index")
     */
    public function index(CategoryRepository $categoryRepository): Response
    {
        return $this->render('backoffice/category/index.html.twig', [
            'categories' => $categoryRepository->findAll(),
        ]);
    }
}