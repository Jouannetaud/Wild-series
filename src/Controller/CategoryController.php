<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Program;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;



class CategoryController extends AbstractController
{

    /**
     * @Route("/categories/", name="category_index")
     * @return Response
     */
    public function index(): Response
     {
        $categories = $this->getDoctrine()
        ->getRepository(Category::class)
        ->findAll();

        return $this->render('category/index.html.twig',['categories'=> $categories]);
     }

     /**
      * @Route("/categories/{categoryName}", name="category_show")
      *@return Response
      */

     public function show(CategoryRepository $categoryRepository, string $categoryName): Response
     {
        $category = $categoryRepository->findOneBy(['name' => $categoryName]);
        
      

    if (!$category) {
        throw $this->createNotFoundException(
            'No category with name : '.$categoryName.' found in category\'s table.'

        );
    }


    $programs = $this->getDoctrine()
    ->getRepository(Program::class)
    ->findBy(['category' => $category],
    ['id' => 'DESC'],3);

    

    return $this->render('category/show.html.twig', [
        'category'=> $category,
        'programs' => $programs
        
        ]);

    }
    /**
     * @Route("/new/" , name= "category_new", methods={"GET","POST"})
     */
    public function new (Request $request): Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($category);
            $entityManager->flush();

            return $this->redirectToRoute('category_index');
        }

        return $this->render('category/new.html.twig', [
        'category' => $category,
        'form' => $form->createView(),
    ]);

    }

}