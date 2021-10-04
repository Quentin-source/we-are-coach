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


        // Pour sauvegarder, on appelle le manager
        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        // On retourne une réponse en indiquant que la ressource
        // a bien été créée (code http 201)
        return $this->json($user, 201);
    }

    


}
