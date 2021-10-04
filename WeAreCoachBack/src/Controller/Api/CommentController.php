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
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;


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

        return $this->json($comment, 200, [], [
            'groups' => 'comment_detail'
        ]);
}
/**
     * @Route("/{id}", name="delete", methods={"DELETE"})
     *
     * @return JsonResponse
     */
    public function delete(int $id, CommentRepository $commentRepository)
    {
        $comment = $commentRepository->find($id);

        if (!$comment) {

            return $this->json(
                [
                    'errors' => ['message' => 'Le commenaitre ' . $id . ' n\'existe pas']
                ],
                404
            );
        }


        $em = $this->getDoctrine()->getManager();
        $em->remove($comment);
        $em->flush();

        return $this->json([
            'message' => 'Le commentaire ' . $id . ' a bien été supprimée'
        ]);
    }

    /**
     *  
     * @Route("/{id}", name="update", methods={"PUT", "PATCH"})
     *
     * @return void
     */
    public function update(int $id, CommentRepository $commentRepository, Request $request, SerializerInterface $serialiser)
    {

        $jsonData = $request->getContent();

        $comment = $commentRepository->find($id);

        if (!$comment) {
            // Si la série à mettre à jour n'existe pas
            // on retourne un message d'erreur (400::bad request ou 404:: not found)
            return $this->json(
                [
                    'errors' => [
                        'message' => 'Le commentaire ' . $id . ' n\'existe pas'
                    ]
                ],
                404
            );
        }


        $serialiser->deserialize($jsonData, Comment::class, 'json', [AbstractNormalizer::OBJECT_TO_POPULATE => $comment]);

        $em = $this->getDoctrine()->getManager();
        $em->flush();

        return $this->json([
            'message' => 'Le commentaire ' . $id . ' a bien été mise à jour'
        ]);
    }

}
