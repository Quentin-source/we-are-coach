<?php

namespace App\Controller\Api;

use App\Entity\Sport;
use App\Repository\WorkoutRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;
use App\Entity\Workout;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

/**
     * @Route("/api/workout", name="api_workout_")
     */
class WorkoutController extends AbstractController
{
    /**
     * @Route("/", name="workout", methods={"GET"})
     */
    public function index(WorkoutRepository $workoutRepository): Response
    {

        $workoutList = $workoutRepository->findAll();

        return $this->json($workoutList, 200, [], [
            'groups' => 'workout_list'
        ]);
    }
    /**
     * 
     * @Route("/{id}", name="show", methods={"GET"})
     * 
     *
     * @return JsonResponse
     */
    public function show(int $id, WorkoutRepository $workoutRepository)
    {
        $workout = $workoutRepository->find($id);

        if (!$workout) {
            return $this->json([
                'error' => 'Lentrainement ' . $id . ' n\'existe pas'
            ], 404);
        }

        return $this->json($workout, 200, [], [
            'groups' => 'workout_detail'
        ]);
    }

    /**
     * 
     * @Route("/add", name="add", methods={"POST"})
     * 
     * @return void
     */
    public function add( Request $request, SerializerInterface $serialiser)
    {
        
        $jsonData = $request->getContent();

        $workout = $serialiser->deserialize($jsonData, Workout::class, 'json');

     
        $em = $this->getDoctrine()->getManager();
        $em->persist($workout);
        $em->flush();

        return $this->json($workout, 200, [], [
        'groups' => 'workout_detail'
        ]);
    }

    /**
     *  
     * @Route("/{id}", name="update", methods={"PUT", "PATCH"})
     *
     * @return void
     */
    public function update(int $id, WorkoutRepository $workoutRepository, Request $request, SerializerInterface $serialiser)
    {
        $jsonData = $request->getContent();

        $workout = $workoutRepository->find($id);

        if (!$workout) {
            return $this->json(
                [
                    'errors' => [
                        'message' => 'L\'entrainement ' . $id . ' n\'existe pas'
                    ]
                ],
                404
            );
        }


        $serialiser->deserialize($jsonData, Workout::class, 'json', [AbstractNormalizer::OBJECT_TO_POPULATE => $workout]);

        $em = $this->getDoctrine()->getManager();
        $em->flush();

        return $this->json([
            'message' => 'L\'entrainement ' . $workout->getName() . ' a bien été mise à jour'
        ]);
    }

    /**
     * @Route("/{id}", name="delete", methods={"DELETE"})
     *
     * @return JsonResponse
     */
    public function delete(int $id, WorkoutRepository $workoutRepository)
    {
        $workout = $workoutRepository->find($id);

        if (!$workout) {
            // La série n'existe pas
            return $this->json(
                [
                    'errors' => ['message' => 'L\'entrainement ' . $id . ' n\'existe pas']
                ],
                404
            );
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($workout);
        $em->flush();

        return $this->json([
            'message' => 'L\'entrainement ' . $id . ' a bien été supprimée'
        ]);
    }


}
