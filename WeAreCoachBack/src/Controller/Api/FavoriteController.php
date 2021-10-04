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

    /**
    *
    * @Route("/{id}", name="show", methods={"GET"})
    *
    *
    * @return JsonResponse
    */
    public function show(int $id, FavoriteRepository $favoriteRepository)
    {
        $favorite = $favoriteRepository->find($id);

        // Si la série n'existe pas, on retourne une erreur 404
        if (!$favorite) {
            return $this->json([
                'error' => 'le favoris ' . $id . ' n\'existe pas'
            ], 404);
        }

        // On retourne le résultat au format JSON
        return $this->json($favorite, 200, [], [
            'groups' => 'favorite_detail'
        ]);
    }

    /**
     *
     * @Route("/add", name="add", methods={"POST"})
     *
     *
     * @return void
     */
    public function add(Request $request, SerializerInterface $serialiser)
    {
        $jsonData = $request->getContent();

        $favorite = $serialiser->deserialize($jsonData, Favorite::class, 'json');
     
        $em = $this->getDoctrine()->getManager();
        $em->persist($favorite);
        $em->flush();

        return $this->json($favorite, 200, [], [
            'groups' => 'favorite_detail'
        ]);
    }

    /**
     * @Route("/{id}", name="delete", methods={"DELETE"})
     *
     * @return JsonResponse
     */
    public function delete(int $id, FavoriteRepository $favoriteRepository)
    {
        $favorite = $favoriteRepository->find($id);

        if (!$favorite) {
            return $this->json(
                [
                    'errors' => ['message' => 'Le favoris ' . $id . ' n\'existe pas']
                ],
                404
            );
        }

        // On appelle le manager pour gérer la suppresion de la série
        $em = $this->getDoctrine()->getManager();
        $em->remove($favorite);
        $em->flush();

        return $this->json([
            'message' => 'Le favoris ' . $id . ' a bien été supprimée'
        ]);
    }
}