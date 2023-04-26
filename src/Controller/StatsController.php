<?php

namespace App\Controller;

use App\Repository\AbsenceRepository;
use App\Repository\JustifyRepository;
use App\Entity\Period;
use App\Repository\LessonRepository;
use App\Repository\PeriodRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class StatsController extends AbstractController
{
    #[Route('/stats', name: 'app_stats_index')]
    public function stats(AbsenceRepository $absenceRepository,PeriodRepository $periodRepository): Response
    {
        $currentUser = $this->getUser();
        $countJustify0 = $absenceRepository ->findByExampleField0();
        $countJustify1 = $absenceRepository ->findByExampleField1();
        $countJustify2 = $absenceRepository ->findByExampleField2();
        $currentUser = $this->getUser();

        return $this->render('stats/index.html.twig', [
            'count_justify0' => $countJustify0,
            'count_justify1' => $countJustify1,
            'count_justify2' => $countJustify2,
            'currentUser' => $currentUser,
        ]);
    }

    #[Route('/stats/lesson', name: 'app_stats_lesson')]
    public function statsLesson(LessonRepository $lessonRepository ,PeriodRepository $periodRepository , Request $request): Response
    {

     //   $currentUser = $this->getUser();
        $session = $periodRepository -> findAll();
        $lessons = $lessonRepository->findAll();

        return $this->render('stats/statsCours.html.twig', [
            'lessons' => $lessons,
            //'currentUser' => $currentUser,
            'session'=>$session,
        ]);
    }


}
