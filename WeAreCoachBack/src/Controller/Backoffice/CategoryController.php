<?php

namespace App\Controller\Backoffice;

use App\Entity\Category;
use App\Form\CategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Service\ImageUploader;

/**
     * @Route("/backoffice/category", name="backoffice_category_", requirements={"id": "\d+"})
     */

class CategoryController extends AbstractController
{
    /**
     * Show all categories from Admin
     *
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(CategoryRepository $categoryRepository): Response
    {
        return $this->render('backoffice/category/index.html.twig', [
            'categories' => $categoryRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id}", name="show", requirements={"id":"\d+"}, methods={"GET"})
     *
     */
    public function show(int $id, CategoryRepository $categoryRepository)
    {
        $category = $categoryRepository->find($id);

        if (!$category) {
            throw $this->createNotFoundException("La catégorie dont l'id est $id n'existe pas");
        }

        return $this->render('backoffice/category/show.html.twig', [
            'category_show' => $category
        ]);
    }

    /**
     * @Route("/add", name="add",  methods={"GET","POST"})
     *
     * @return Response
     */
    public function add(Request $request, ImageUploader $imageUploader)
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $newFile = $imageUploader->upload($form, 'picture');
            if ($newFile){
                $category->setPicture($newFile);
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();

            $this->addFlash('success', 'La catégorie ' . $category->getName() . ' a bien été créé');

            return $this->redirectToRoute('backoffice_category_index');
        }

        return $this->render('backoffice/category/add.html.twig', [
            'formView' => $form->createView()
        ]);
    }

    /**
     * 
     * @Route("/{id}/edit", name="edit")
     *
     * @return Response
     */
    public function edit(Category $category, Request $request)
    {
        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();

            $this->addFlash('success', 'La catégorie ' . $category->getName() . ' a bien été modifiée');

            return $this->redirectToRoute('backoffice_category_index');
        }

        return $this->render('backoffice/category/edit.html.twig', [
            'formView' => $form->createView()
        ]);
    }

    /**
     * 
     * @Route("/{id}/delete", name="delete")
     * 
     * @return Response
     */
    public function delete(category $category)
    {
        // On supprime la catégorie en BDD
        $em = $this->getDoctrine()->getManager();
        $em->remove($category);
        $em->flush();

        // Message flash
        $this->addFlash('info', 'La catégorie ' . $category->getName() . ' a bien été supprimée');

        return $this->redirectToRoute('backoffice_category_index');
    }

}