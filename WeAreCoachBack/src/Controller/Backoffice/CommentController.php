<?php

namespace App\Controller\Backoffice;

use App\Entity\Comment;
use App\Repository\CommentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
     * @Route("/backoffice/comment", name="backoffice_comment_", requirements={"id": "\d+"})
     */

class CommentController extends AbstractController
{

    /**
     * Show all categories from Admin
     *
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(CommentRepository $commentRepository): Response
    {
        return $this->render('backoffice/comment/index.html.twig', [
            'comments' => $commentRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id}", name="show", requirements={"id":"\d+"}, methods={"GET"})
     *
     */
    public function show(int $id, CommentRepository $commentRepository)
    {
        $comment = $commentRepository->find($id);

        if (!$comment) {
            throw $this->createNotFoundException("L'entraînement dont l'id est $id n'existe pas");
        }

        return $this->render('backoffice/comment/show.html.twig', [
            'comment_show' => $comment,

        ]);
        
    }


    /**
     * 
     * @Route("/{id}/delete", name="delete")
     * 
     * @return Response
     */
    public function delete(Comment $comment)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($comment);
        $em->flush();

        // Message flash
        $this->addFlash('info', 'Le commentaire ' . $comment->getComment() . ' a bien été supprimé');

        return $this->redirectToRoute('backoffice_comment_index');
    }
}
