<?php

namespace App\Controller\Api;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
     * @Route("/api/category", name="api_category_")
     */
    class CategoryController extends AbstractController
    {
        /**
         * @Route("/", name="category", methods={"GET"})
         */
        public function index(CategoryRepository $categoryRepository): Response
        {
    
            $categoryList = $categoryRepository->findAll();
    
            return $this->json($categoryList, 200, [], [
                'groups' => 'category_list'
            ]);
        }
        /**
         * 
         * @Route("/{id}", name="show", methods={"GET"})
         * 
         *
         * @return JsonResponse
         */
        public function show(int $id, CategoryRepository $categoryRepository)
        {
            // On récupère une série en fonction de son id
            $category = $categoryRepository->find($id);
    
            // Si la série n'existe pas, on retourne une erreur 404
            if (!$category) {
                return $this->json([
                    'error' => 'La categorie ' . $id . ' n\'existe pas'
                ], 404);
            }
    
            // On retourne le résultat au format JSON
            return $this->json($category, 200, [], [
                'groups' => 'category_detail'
            ]);
        }
}