<?php

namespace App\Controller\Backoffice;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Workout;
use App\Repository\WorkoutRepository;
use App\Entity\Sport;
use Symfony\Component\HttpFoundation\Request;
use App\Service\ImageUploader;
use App\Form\WorkoutType;

    /**
     * @Route("/backoffice/workout", name="backoffice_workout_")
     */

class WorkoutController extends AbstractController
{
    /**
     * Show all categories from Admin 
     * 
     * @Route("/", name="index")
     */
    public function index(WorkoutRepository $workoutRepository): Response
    {
        return $this->render('backoffice/workout/index.html.twig', [
            'workouts' => $workoutRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id}", name="show", requirements={"id":"\d+"}, methods={"GET"})
     *
     */
    public function show(int $id, WorkoutRepository $workoutRepository)
    {
        $workout = $workoutRepository->find($id);

        if (!$workout) {
            throw $this->createNotFoundException("L'entrainement' dont l'id est $id n'existe pas");
        }

        return $this->render('backoffice/workout/show.html.twig', [
            'workout_show' => $workout
        ]);
    }
        /**
     * @Route("/add", name="add",  methods={"GET","POST"})
     *
     * @return Response
     */
    public function add(Request $request, ImageUploader $imageUploader)
    {
        $workout = new Workout();
        $form = $this->createForm(WorkoutType::class, $workout);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $newFile = $imageUploader->upload($form, 'picture');
            if ($newFile){
                $workout->setPicture($newFile);
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($workout);
            $em->flush();

            $this->addFlash('success', 'Le entrainement ' . $workout->getName() . ' a bien été créé');

            return $this->redirectToRoute('backoffice_workout_index');
        }

        return $this->render('backoffice/workout/add.html.twig', [
            'formView' => $form->createView()
        ]);
    }

    /**
     * 
     * @Route("/{id}/edit", name="edit")
     *
     * @return Response
     */
    public function edit(Workout $workout, Request $request)
    {
        $form = $this->createForm(WorkoutType::class, $workout);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($workout);
            $em->flush();

            $this->addFlash('success', 'Le entrainement ' . $workout->getName() . ' a bien été modifiée');

            return $this->redirectToRoute('backoffice_workout_index');
        }

        return $this->render('backoffice/workout/edit.html.twig', [
            'formView' => $form->createView()
        ]);
    }

    /**
     * 
     * @Route("/{id}/delete", name="delete")
     * 
     * @return Response
     */
    public function delete(Workout $workout)
    {
        // On supprime la catégorie en BDD
        $em = $this->getDoctrine()->getManager();
        $em->remove($workout);
        $em->flush();

        // Message flash
        $this->addFlash('info', 'Le entrainement ' . $workout->getName() . ' a bien été supprimée');

        return $this->redirectToRoute('backoffice_workout_index');
    }
}