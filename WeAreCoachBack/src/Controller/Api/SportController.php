<?php

namespace App\Controller\Api;

use App\Entity\Sport;
use App\Repository\SportRepository;
use App\Service\ImageUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


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
            $sport = $sportRepository->find($id);
    
            if (!$sport) {
                return $this->json([
                    'error' => 'Le sport ' . $id . ' n\'existe pas'
                ], 404);
            }
    
            return $this->json($sport, 200, [], [
                'groups' => 'sport_detail'
            ]);
        }

    
}