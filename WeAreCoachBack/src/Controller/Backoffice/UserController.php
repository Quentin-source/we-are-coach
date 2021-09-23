<?php

namespace App\Controller\Backoffice;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/backoffice/user", name="backoffice_user")
     */
    public function index(): Response
    {
        return $this->render('backoffice/user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
}
