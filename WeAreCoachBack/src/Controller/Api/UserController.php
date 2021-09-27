<?php

namespace App\Controller\Api;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
}
