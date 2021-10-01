<?php

namespace App\Controller\Backoffice;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Repository\UserRepository;
use App\Service\ImageUploader;
use Symfony\Component\HttpFoundation\Request;
use App\Form\UserType;

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

        /**
     * @Route("/{id}", name="show", requirements={"id":"\d+"}, methods={"GET"})
     *
     */
    public function show(int $id, UserRepository $userRepository)
    {
        $user = $userRepository->find($id);

        if (!$user) {
            throw $this->createNotFoundException("Le user dont l'id est $id n'existe pas");
        }

        return $this->render('backoffice/user/show.html.twig', [
            'user_show' => $user
        ]);
    }

    /**
     * @Route("/add", name="add",  methods={"GET","POST"})
     *
     * @return Response
     */
    public function add(Request $request, ImageUploader $imageUploader)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $newFile = $imageUploader->upload($form, 'picture');
            if ($newFile){
                $user->setPicture($newFile);
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'Le user ' . $user->getPseudo() . ' a bien été créé');

            return $this->redirectToRoute('backoffice_user_index');
        }

        return $this->render('backoffice/user/add.html.twig', [
            'formView' => $form->createView()
        ]);
    }

    /**
     * 
     * @Route("/{id}/edit", name="edit")
     *
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

            $this->addFlash('success', 'Le user ' . $user->getPseudo() . ' a bien été modifiée');

            return $this->redirectToRoute('backoffice_user_index');
        }

        return $this->render('backoffice/user/edit.html.twig', [
            'formView' => $form->createView()
        ]);
    }

    /**
     * 
     * @Route("/{id}/delete", name="delete")
     * 
     * @return Response
     */
    public function delete(User $user)
    {
        // On supprime la catégorie en BDD
        $em = $this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();

        // Message flash
        $this->addFlash('info', 'Le user ' . $user->getPseudo() . ' a bien été supprimée');

        return $this->redirectToRoute('backoffice_user_index');
    }
}