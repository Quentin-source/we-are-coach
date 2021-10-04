<?php

namespace App\Controller\Api;

use App\Repository\SportRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
     * @Route("/api/sport", name="api_sport_")
     */
    class SportController extends AbstractController
    {
        /**
         * @Route("/", name="sport", methods={"GET"})
         */
        public function index(SportRepository $sportRepository): Response
        {
    
            $sportList = $sportRepository->findAll();
    
            return $this->json($sportList, 200, [], [
                'groups' => 'sport_list'
            ]);
        }
        /**
         * 
         * @Route("/{id}", name="show", methods={"GET"})
         * 
         *
         * @return JsonResponse
         */
        public function show(int $id, SportRepository $sportRepository)
        {
            // On récupère une série en fonction de son id
            $sport = $sportRepository->find($id);
    
            // Si la série n'existe pas, on retourne une erreur 404
            if (!$sport) {
                return $this->json([
                    'error' => 'Le sport ' . $id . ' n\'existe pas'
                ], 404);
            }
    
            // On retourne le résultat au format JSON
            return $this->json($sport, 200, [], [
                'groups' => 'sport_detail'
            ]);
        }
}