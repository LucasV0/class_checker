<?php

namespace App\Controller;

use App\Entity\Lesson;
use App\Entity\ToHave;
use App\Form\ToHaveType;
use App\Repository\LessonRepository;
use App\Repository\PeriodRepository;
use App\Repository\StudentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use function PHPUnit\Framework\countOf;

class TohaveController extends AbstractController
{
    #[Route('/tohave', name: 'app_tohave' , methods: ['GET', 'POST'])]
    public function insert(EntityManagerInterface $manager, Request $request,Lesson $lesson, StudentRepository $studentRepository): Response
    {
        $students = $studentRepository->findall();
            if ($request->getmethod() === 'POST'){
                $student=$request->get('student');
                if (isset($student)&&isset($tohave)){
                    for ($i = 0; $i < count($student); $i++) {
                        $tohave = new ToHave();
                        $tohave->setStudents($studentRepository->findOneBy(['id'=>$student[$i]]));
                        $tohave->setLessons($lesson);
                        $manager->persist($tohave);
                   }
                    $manager->flush();
                    return $this->redirectToRoute("app_lesson");
               }
                $this->addFlash('error', 'Aucun étudiant séléctionné.');
                return $this->redirectToRoute("app_tohave");
            }
        return $this->render('tohave/index.html.twig', [
            'lesson' => $lesson,
            'students' => $students,
            ]);
    }
}
