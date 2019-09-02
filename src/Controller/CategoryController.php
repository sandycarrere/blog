<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


/**
 * @Route("/category", name="category_")
 */

class CategoryController extends AbstractController
{
    /**
     * @Route("/show", name="admin_index")
     */
    //Cette méthode affiche toutes mes catégories
    public function show(): Response
    {
        $category = $this->getDoctrine()->getRepository(Category::class)->findAll();
        return $this->render('category/index.html.twig', [
            'controller_name' => 'CategoryController',
            'categories' => $category,
        ]);
    }

    /**
     * @Route("/add", name="admin_add")
     */

    public function add(Request $request)
    {
        $category = new Category();
        $form = $this->createForm(
            CategoryType::class,
            $category,
            ['method' => Request::METHOD_GET]
        );
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($data);
            $entityManager->flush();
            return $this->redirectToRoute('category_admin_index');
        }
        return $this->render('category/add.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
