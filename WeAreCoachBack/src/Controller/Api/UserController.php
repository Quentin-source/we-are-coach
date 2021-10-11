<?php

namespace App\Controller\Api;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

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
     * @Route("/{id}", name="show", methods={"GET"})
     *
     * @return JsonResponse
     */
    public function show(int $id, UserRepository $userRepository)
    {
 
        $user = $userRepository->find($id);

        if (!$user) {
            return $this->json([
                'error' => 'L\'utilisateur ' . $id . ' n\'existe pas'
            ], 404);
        }

        return $this->json($user, 200, [], [
            'groups' => ['user_detail','workout_list']
        ]);
    }

    /**
     * Mise à jour d'une série en fonction de son Identifiant
     * 
     * @Route("/{id}", name="update", methods={"PUT", "PATCH"})
     *
     * @return void
     */
    public function update(int $id, UserRepository $userRepository, Request $request, SerializerInterface $serialiser,UserPasswordHasherInterface $passwordHasher)
    {

        $jsonData = $request->getContent();

        $user = $userRepository->find($id);

        if (!$user) {
            // Si l'utilisateur à mettre à jour n'existe pas
            // on retourne un message d'erreur (400::bad request ou 404:: not found)
            return $this->json(
                [
                    'errors' => [
                        'message' => 'L\'utilisateur ' . $id . ' n\'existe pas'
                    ]
                ],
                404
            );
        }

        $serialiser->deserialize($jsonData, User::class, 'json', [AbstractNormalizer::OBJECT_TO_POPULATE => $user]);

        $user->setPassword(
            $passwordHasher->hashPassword($user,$user->getPassword())
            );
        // On appelle le manager pour effectuer la mise à jour en BDD
        $em = $this->getDoctrine()->getManager();
        $em->flush();

        return $this->json([
            'message' => 'L\'utilisateur ' . $user->getPseudo() . ' a bien été mise à jour'
        ]);
    }

        /**
     * @Route("/{id}", name="delete", methods={"DELETE"})
     *
     * @return JsonResponse
     */
    public function delete(int $id, UserRepository $userRepository)
    {
        $user = $userRepository->find($id);

        if (!$user) {
            // La série n'existe pas
            return $this->json(
                [
                    'errors' => ['message' => 'L\'utilisateur ' . $id . ' n\'existe pas']
                ],
                404
            );
        }

        // On appelle le manager pour gérer la suppresion de la série
        $em = $this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();

        return $this->json([
            'message' => 'L\'utilisateur ' . $id . ' a bien été supprimée'
        ]);
    }
}
