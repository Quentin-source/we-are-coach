<?php

namespace App\Controller\Api;

use App\Entity\Favorite;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;
use App\Repository\FavoriteRepository;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

/**
     * @Route("/api/favorite", name="api_favorite_")
     */
class FavoriteController extends AbstractController
{
    /**
     * @Route("/", name="favorite", methods={"GET"})
     */
    public function index(FavoriteRepository $favoriteRepository): Response
    {
        $favorite = $favoriteRepository->findAll();

        return $this->json($favorite, 200, [], [
            'groups' => 'favorite_list'
        ]);
    }
}