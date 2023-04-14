<?php

namespace App\Controller;

use App\Entity\Absence;
use App\Entity\Lesson;
use App\Entity\Student;
use App\Entity\User;
use App\Repository\AbsenceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    
    #[Route('/', name: 'app_home')]
    public function index(EntityManagerInterface $entityManager, AbsenceRepository $absenceRepository): Response
    {
        
        $users = $entityManager->getRepository(User::class)->findAll();
        $student = $entityManager->getRepository(Student::class)->findAll();
        $lesson = $entityManager->getRepository(Lesson::class)->findAll();
        $absence = $entityManager->getRepository(Absence::class)->findAll();
        $countJustify0 = $absenceRepository ->findByExampleField0();
        $countJustify1 = $absenceRepository ->findByExampleField1();
        $countJustify2 = $absenceRepository ->findByExampleField2();
        $currentUser = $this->getUser();

        return $this->render('dashboard.html.twig', [
            'currentUser' => $currentUser,
            'users' => $users,
            'student' => $student,
            'lesson' => $lesson,
            'absence' => $absence,
            'count_justify0' => $countJustify0,
            'count_justify1' => $countJustify1,
            'count_justify2' => $countJustify2,
        ]);
    }
    
}
