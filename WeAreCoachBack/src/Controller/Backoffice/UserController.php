<?php

namespace App\Controller\Backoffice;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Repository\UserRepository;

    /**
     * @Route("/backoffice/user", name="backoffice_user_")
     */

class UserController extends AbstractController
{
    /**
     * Show all categories from Admin 
     * 
     * @Route("/", name="index")
     */
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('backoffice/user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

}