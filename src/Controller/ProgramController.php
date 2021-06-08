<?php
// src/Controller/ProgramController.php
namespace App\Controller;

use App\Entity\Program;
use App\Repository\ProgramRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProgramController extends AbstractController
{
    /**
     * @Route("/programs/", name="program_index")
     * @return Response A response instance
     */

    public function index(ProgramRepository $programRepository): Response
    {
        $programs = $programRepository->findAll();
    
        return $this->render('program/index.html.twig',['programs'=> $programs]);
            
    }

    
    /**
     * @Route("/programs/{id}" , methods={"GET"}, requirements={"page"="\d+"}, name= "program_show")
     */

    public function show(int $id):Response
    {
        $program = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findOneBy(['id' => $id]);
    
        if (!$program) {
            throw $this->createNotFoundException(
                'No program with id : '.$id.' found in program\'s table.'
            );
        }
        return $this->render('program/show.html.twig', [
            'program' => $program,
        ]);
    }

}