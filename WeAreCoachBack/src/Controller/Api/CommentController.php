<?php

namespace App\Controller\Api;

use App\Entity\Comment;
use App\Repository\CommentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;


/**
 * @Route("/api/comment", name ="api_comment_")
 */
class CommentController extends AbstractController
{
    /**
     * @Route("/", name="comment")
     */
    public function comment(CommentRepository $commentRepository): Response
    {

        $commentList = $commentRepository->findAll();

        return $this->json($commentList, 200, [], [
            'groups' => 'comment_list',
        ]);
    }

     /**
     * 
     * @Route("/{id}", name="show", methods={"GET"})
     * 
     *
     * @return JsonResponse
     */
    public function show(int $id, CommentRepository $commentRepository)
    {
 
        $comment = $commentRepository->find($id);

        // Si la série n'existe pas, on retourne une erreur 404
        if (!$comment) {
            return $this->json([
                'error' => 'le commentaire ' . $id . ' n\'existe pas'
            ], 404);
        }

        // On retourne le résultat au format JSON
        return $this->json($comment, 200, [], [
            'groups' => 'comment_detail'
        ]);
    }

    /**
     * 
     * @Route("/add", name="add", methods={"POST"})
     * 
     *
     * @return void
     */
    public function add( Request $request, SerializerInterface $serialiser)
    {
        
        $jsonData = $request->getContent();

        $comment = $serialiser->deserialize($jsonData, Comment::class, 'json');
     
        $em = $this->getDoctrine()->getManager();
        $em->persist($comment);
        $em->flush();

        return $this->json($comment, 200, [], [ObjectNormalizer::CIRCULAR_REFERENCE_HANDLER=> function($object){
            return $object->getName();
        }]);
    } 
}
