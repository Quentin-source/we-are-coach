<?php

namespace App\Controller\Api;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;

    /**
     * @Route("/api/user", name="api_user_")
     */
class UserController extends AbstractController
{
    /**
     * @Route("/", name="user", methods={"GET"})
     */
    public function index(UserRepository $userRepository): Response
    {
        $userList = $userRepository->findAll();

        return $this->json($userList, 200, [], [
            'groups' => 'user_list',
        ]);
    }

    /**
     * 
     * @Route("/", name="add", methods={"POST"})
     *
     * @return void
     */
    public function add(Request $request, SerializerInterface $serialiser)
    {
        // 1) On récupère le JSON
        $jsonData = $request->getContent();

        // 2) On transforme le json en objet : désérialisation
        // - On indique les données à transformer (désérialiser)
        // - On indique le format d'arrivé après conversion (objet de type TvShow)
        // - On indique le format de départ : on veut passer de json vers un objet TvShow
        $user = $serialiser->deserialize($jsonData, User::class, 'json');


        // Pour sauvegarder, on appelle le manager
        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        // On retourne une réponse en indiquant que la ressource
        // a bien été créée (code http 201)
        return $this->json($user, 201);
    }


}
