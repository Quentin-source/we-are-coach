<?php

namespace App\Controller\Api;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class RegistrationController extends AbstractController
{
    /**
     * 
     * @Route("api/registration", name="api_registration", methods={"POST"})
     *
     * @return void
     */
    public function add(Request $request, SerializerInterface $serialiser,UserPasswordHasherInterface $passwordHasher)
    {

        $jsonData = $request->getContent();

        $user = $serialiser->deserialize($jsonData, User::class, 'json');

        $user->setPassword(
            $passwordHasher->hashPassword($user,$user->getPassword())
            );


        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        return $this->json($user, 201);
    }

    


}
