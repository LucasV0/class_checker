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
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;
//Début du controlleur Student
class StudentController extends AbstractController
{
    /**
     * @param StudentRepository $repository
     * @param Breadcrumbs $breadcrumbs
     * @return Response
     */
    #[Route('/student', name: 'app_student', methods: ['GET'])]
    public function index(StudentRepository $repository, Breadcrumbs $breadcrumbs): Response
    {
        $breadcrumbs->addItem('Dashboard', $this->generateUrl('app_home'));
        $breadcrumbs->addItem('Étudiants', $this->generateUrl('app_student'));
        if($this->getUser() === null){
            $this->addFlash('error', 'Vous devez vous connecter pour acceder a ce contenu');
            return $this->redirectToRoute('app_login');
        }
        $students = $repository->findAll();
        $currentUser = $this->getUser();
        return $this->render('student/index.html.twig', [
            'students' => $students,
            'currentUser' => $currentUser,
        ]);
    }

    /**
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @param Breadcrumbs $breadcrumbs
     * @return Response
     */
    #[Route('/student/create', name: 'app_student_create', methods: ['GET' , 'POST'])]
    public function createStudent(Request $request, EntityManagerInterface $manager, Breadcrumbs $breadcrumbs): Response
    {
        $breadcrumbs->addItem('Dashboard', $this->generateUrl('app_home'));
        $breadcrumbs->addItem('Étudiants', $this->generateUrl('app_student'));
        $breadcrumbs->addItem('Créer', $this->generateUrl('app_student_create'));
        if($this->getUser() === null){
            $this->addFlash('error', 'Vous devez vous connecter pour acceder a ce contenu');
            return $this->redirectToRoute('app_login');
        }
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
            $code = strtoupper($surname) . strtoupper($name) . $bday;
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
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @param Student $student
     * @param Breadcrumbs $breadcrumbs
     * @return Response
     */
    #[Route('/student/update/{id}', name: 'app_student_update', methods: ['GET' , 'POST'])]
    public function updateStudent(Request $request, EntityManagerInterface $manager, Student $student, Breadcrumbs $breadcrumbs): Response
    {
        $breadcrumbs->addItem('Dashboard', $this->generateUrl('app_home'));
        $breadcrumbs->addItem('Étudiants', $this->generateUrl('app_student'));
        $breadcrumbs->addItem('Modifier', $this->generateUrl('app_student_update', ['id' => $student->getId()]));
        if($this->getUser() === null){
            $this->addFlash('error', 'Vous devez vous connecter pour acceder a ce contenu');
            return $this->redirectToRoute('app_login');
        }
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
     * @param EntityManagerInterface $manager
     * @param Student $student
     * @return Response
     */
    #[Route('/student/delete/{id}', name: 'app_student_delete', methods: ['GET' , 'POST'])]
    public function delete(EntityManagerInterface $manager, Student $student): Response
    {
        if($this->getUser() === null){
            $this->addFlash('error', 'Vous devez vous connecter pour acceder a ce contenu');
            return $this->redirectToRoute('app_login');
        }
        $currentUser = $this->getUser();
        $manager->remove($student);
        $manager->flush();

        $this->addFlash('success', 'L\'éléve a bien été supprimé');
        return  $this->redirectToRoute('app_student',['currentUser' => $currentUser,]);
        
    }
}
