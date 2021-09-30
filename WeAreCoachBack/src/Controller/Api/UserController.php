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
            'groups' => 'user_detail'
        ]);
    }


}
