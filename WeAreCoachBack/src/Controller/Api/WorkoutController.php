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
     * @return JsonResponse
     */
    public function show(int $id, WorkoutRepository $workoutRepository)
    {
        // On récupère une série en fonction de son id
        $workout = $workoutRepository->find($id);

        // Si la série n'existe pas, on retourne une erreur 404
        if (!$workout) {
            return $this->json([
                'error' => 'Lentrainement ' . $id . ' n\'existe pas'
            ], 404);
        }

        // On retourne le résultat au format JSON
        return $this->json($workout, 200, [], [
            'groups' => 'workout_detail'
        ]);
    }

        /**
     * 
     * @Route("/add", name="user", methods={"POST"})
     *
     * @return void
     */
    public function add( Request $request, SerializerInterface $serialiser)
    {
        

        $jsonData = $request->getContent();

        $workout = $serialiser->deserialize($jsonData, Workout::class, 'json');

        // $sport->addWorkout($workout);

        $em = $this->getDoctrine()->getManager();
        $em->persist($workout);
        $em->flush();

        return $this->json($workout, 201);
    }

}
