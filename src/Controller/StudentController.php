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
//Début du controlleur Student
class StudentController extends AbstractController
{
    /**
     * Redirige vers la list des students
     * @author Alexandre Messuve
     * @param StudentRepository $repository
     * @return Response
     */
    #[Route('/student', name: 'app_student', methods: ['GET'])]
    public function index(StudentRepository $repository): Response
    {
        
        $students = $repository->findAll();
        $currentUser = $this->getUser();
        return $this->render('student/index.html.twig', [
            'students' => $students,
            'currentUser' => $currentUser,
        ]);
    }

    /**
     * Redirige vers le formulaire de creation de student
     * @author Alexandre Messuve
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    #[Route('/student/create', name: 'app_student_create', methods: ['GET' , 'POST'])]
    public function createStudent(Request $request, EntityManagerInterface $manager): Response
    {
        $currentUser = $this->getUser();
        $student = new Student();
        $form = $this->createForm(StudentType::class, $student);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $student = $form->getData();
            $name = $student->getName();
            $surname = $student->getSurname();
            $bday = $student->getBirthday();
            $name = substr($name, 0, 3);
            $surname = substr($surname, 0,1);
            $bday = $bday->format('y');
            $code = $surname . $name . $bday;
            $student->setVerifCode($code);
            $manager->persist($student);
            $manager->flush();
            $this->addFlash(
                'success',
                'L\'éléve a bien été ajouté'
            );

            return $this->redirectToRoute('app_student');
        }
        return $this->render('student/form.html.twig', [
            'form' => $form->createView(),
            'route' => 'app_student_create',
            'currentUser' => $currentUser,
        ]);
    }

    /**
     * Permet d'update les student
     * @author Alexandre Messuve
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @param Student $student
     * @return Response
     */
    #[Route('/student/update/{id}', name: 'app_student_update', methods: ['GET' , 'POST'])]
    public function updateStudent(Request $request, EntityManagerInterface $manager, Student $student): Response
    {
        $currentUser = $this->getUser();
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
            'form' => $form->createView(),
            'route' => 'app_student_update',
            'currentUser' => $currentUser,
        ]);
    }

    /**
     * Permet de supprimer un student
     * @author Alexandre Messuve
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @param Student $student
     * @return Response
     */
    #[Route('/student/delete/{id}', name: 'app_student_delete', methods: ['GET' , 'POST'])]
    public function delete(EntityManagerInterface $manager, Student $student): Response
    {
        $currentUser = $this->getUser();
        $manager->remove($student);
        $manager->flush();

        $this->addFlash('success', 'L\'éléve a bien été supprimé');
        return  $this->redirectToRoute('app_student',['currentUser' => $currentUser,]);
        
    }
}
