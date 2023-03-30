<?php

namespace App\Controller;

use App\Entity\Student;
use App\Form\StudentType;
use App\Repository\StudentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StudentController extends AbstractController
{

    /**
     * @return Response
     */
    #[Route('/student', name: 'app_student', methods: ['GET'])]
    public function index(StudentRepository $repository): Response
    {
        $students = $repository->findAll();
        return $this->render('student/index.html.twig', [
            'students' => $students,
        ]);
    }

    /**
     * @return Response
     */
    #[Route('/student/create', name: 'app_student_create', methods: ['GET' , 'POST'])]
    public function createStudent(Request $request, EntityManagerInterface $manager): Response
    {
        $student = new Student();
        $form = $this->createForm(StudentType::class, $student);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $student = $form->getData();
            $manager->persist($student);
            $manager->flush();
            $this->addFlash(
                'success',
                'L\'éléve a bien été ajouté'
            );

            return $this->redirectToRoute('app_student');
        }
        return $this->render('student/form.html.twig', [
            'form' => $form->createView()
        ]);
    }
    #[Route('/student/update/{id}', name: 'app_student_update', methods: ['GET' , 'POST'])]
    public function updateStudent(Request $request, EntityManagerInterface $manager, Student $student): Response
    {
        $form = $this->createForm(StudentType::class, $student);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $student = $form->getData();
            $manager->persist($student);
            $manager->flush();
            $this->addFlash(
                'success',
                'L\'éléve a bien été mis a jour'
            );

            return $this->redirectToRoute('app_student');
        }
        return $this->render('student/form.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/student/delete/{id}', name: 'app_student_delete', methods: ['GET' , 'POST'])]
    public function delete(EntityManagerInterface $manager, Student $student): Response
    {
        $manager->remove($student);
        $manager->flush();

        $this->addFlash('success', 'L\'éléve a bien été supprimé');
        return  $this->redirectToRoute('app_student');
    }
}
