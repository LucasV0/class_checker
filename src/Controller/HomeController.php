<?php

namespace App\Controller;

use App\Entity\Absence;
use App\Entity\Lesson;
use App\Entity\Student;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    
    #[Route('/', name: 'app_home')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $users = $entityManager->getRepository(User::class)->findAll();
        $student = $entityManager->getRepository(Student::class)->findAll();
        $lesson = $entityManager->getRepository(Lesson::class)->findAll();
        $absence = $entityManager->getRepository(Absence::class)->findAll();

        return $this->render('dashboard.html.twig', [
            'users' => $users,
            'student' => $student,
            'lesson' => $lesson,
            'absence' => $absence,
            'controller_name' => 'HomeController',
        ]);
    }
    
}
