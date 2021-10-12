<?php

namespace App\Controller\Backoffice;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Service\ImageUploader;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
     * @Route("/backoffice/user", name="backoffice_user_", requirements={"id": "\d+"})
     */

class UserController extends AbstractController
{
    /**
     * Show all categories from Admin
     *
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('backoffice/user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id}", name="show", requirements={"id":"\d+"}, methods={"GET"})
     *
     */
    public function show(int $id, UserRepository $userRepository)
    {
        $user = $userRepository->find($id);

        if (!$user) {
            throw $this->createNotFoundException("L'utilisateur' dont l'id est $id n'existe pas");
        }

        return $this->render('backoffice/user/show.html.twig', [
            'user_show' => $user
        ]);
    }

    /**
     * @Route("/add", name="add",  methods={"GET","POST"})
     * @IsGranted("ROLE_SUPER_ADMIN")
     * @return Response
     */
    public function add(Request $request, ImageUploader $imageUploader, UserPasswordHasherInterface $passwordHasher)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $newFile = $imageUploader->upload($form, 'picture');
            $user->setPassword(
            $passwordHasher->hashPassword($user,$user->getPassword())
            );
            if ($newFile){
                $user->setPicture($newFile);
                $user->setPassword(
                    $passwordHasher->hashPassword($user,$user->getPassword())
                    );
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'L\'utilisateur ' . $user->getPseudo() . ' a bien été créé');

            return $this->redirectToRoute('backoffice_user_index');
        }

        return $this->render('backoffice/user/add.html.twig', [
            'formView' => $form->createView()
        ]);
    }

    /**
     * 
     * @Route("/{id}/edit", name="edit")
     * @IsGranted("ROLE_SUPER_ADMIN")
     * @return Response
     */
    public function edit(User $user, Request $request)
    {
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'L\'utilisateur ' . $user->getPseudo() . ' a bien été modifié');

            return $this->redirectToRoute('backoffice_user_index');
        }

        return $this->render('backoffice/user/edit.html.twig', [
            'formView' => $form->createView()
        ]);
    }

    /**
     * 
     * @Route("/{id}/delete", name="delete")
     * @IsGranted("ROLE_SUPER_ADMIN")
     * @return Response
     */
    public function delete(User $user)
    {
        // On supprime la catégorie en BDD
        $em = $this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();

        // Message flash
        $this->addFlash('info', 'L\'utilisateur ' . $user->getPseudo() . ' a bien été supprimé');

        return $this->redirectToRoute('backoffice_user_index');
    }

}