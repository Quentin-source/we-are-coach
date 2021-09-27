<?php

namespace App\Controller\Backoffice;

use App\Entity\Category;
use App\Entity\Sport;
use App\Form\SportType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\SportRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Service\ImageUploader;
use DateTimeImmutable;

/**
     * @Route("/backoffice/sport", name="backoffice_sport_", requirements={"id": "\d+"})
     */

class SportController extends AbstractController
{
    /**
     * Show all categories from Admin
     *
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(SportRepository $sportRepository): Response
    {
        return $this->render('backoffice/sport/index.html.twig', [
            'sports' => $sportRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id}", name="show", requirements={"id":"\d+"}, methods={"GET"})
     *
     */
    public function show(int $id, SportRepository $sportRepository)
    {
        $sport = $sportRepository->find($id);

        if (!$sport) {
            throw $this->createNotFoundException("Le sport dont l'id est $id n'existe pas");
        }

        return $this->render('backoffice/sport/show.html.twig', [
            'sport_show' => $sport
        ]);
    }

    /**
     * @Route("/add", name="add",  methods={"GET","POST"})
     *
     * @return Response
     */
    public function add(Request $request, ImageUploader $imageUploader)
    {
        $sport = new Sport();
        $form = $this->createForm(SportType::class, $sport);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $newFile = $imageUploader->upload($form, 'picture');
            if ($newFile){
                $sport->setPicture($newFile);
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($sport);
            $em->flush();

            $this->addFlash('success', 'Le sport ' . $sport->getName() . ' a bien été créé');

            return $this->redirectToRoute('backoffice_sport_index');
        }

        return $this->render('backoffice/sport/add.html.twig', [
            'formView' => $form->createView()
        ]);
    }

    /**
     * 
     * @Route("/{id}/edit", name="edit")
     *
     * @return Response
     */
    public function edit(Sport $sport, Request $request)
    {
        $form = $this->createForm(SportType::class, $sport);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($sport);
            $em->flush();

            $this->addFlash('success', 'Le sport ' . $sport->getName() . ' a bien été modifiée');

            return $this->redirectToRoute('backoffice_sport_index');
        }

        return $this->render('backoffice/sport/edit.html.twig', [
            'formView' => $form->createView()
        ]);
    }

    /**
     * 
     * @Route("/{id}/delete", name="delete")
     * 
     * @return Response
     */
    public function delete(Sport $sport)
    {
        // On supprime la catégorie en BDD
        $em = $this->getDoctrine()->getManager();
        $em->remove($sport);
        $em->flush();

        // Message flash
        $this->addFlash('info', 'Le sport ' . $sport->getName() . ' a bien été supprimée');

        return $this->redirectToRoute('backoffice_sport_index');
    }

}