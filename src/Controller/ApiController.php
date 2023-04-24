<?php

namespace App\Controller;

use App\Repository\LessonRepository;
use App\Repository\PeriodRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{
    #[Route('/api/session', name: 'app_api_session')]
    public function session(PeriodRepository $periodRepository): JsonResponse
    {
        $sessions = $periodRepository->findAll();
        $json= [];
        foreach ($sessions as $session){
            $json[] = [
                'period' => [
                    'session' => $session->getSession(),
                    'id' => $session->getId()
                ]
            ];
        }


        return new JsonResponse($json);
    }

    #[Route('/api/lesson', name: 'app_api_lesson')]
    public function lesson(LessonRepository $lessonRepository, Request $request, PeriodRepository $periodRepository): JsonResponse
    {
        $json= [];
        if ($request->isXmlHttpRequest()){
            $session = $periodRepository->findOneBy(['id' => $request->get('session')]);
            $lessons = $lessonRepository->findBySession($session->getSession());
            foreach ($lessons as $lesson){
                $json[] = [
                    'lesson' => [
                        'label' => $lesson->getLabel(),
                        'id' => $lesson->getId(),
                        'prof_name' => $lesson->getTeacher()->getNom(),
                        'prof_surname' => $lesson->getTeacher()->getPrenom(),
                        'student' => $lesson->getToHave()->count(),
                        'max_student' => $lesson->getNumberMaxOfStudents(),
                        'period_start' => $lesson->getTimeStart()->format('d/m/Y'),
                        'period_end' => $lesson->getTimeEnd()->format('d/m/Y'),
                        'day' => $lesson->getDay(),
                        'hour_start' => $lesson->getHoursStart()->format('H:i'),
                        'hour_end' => $lesson->getHoursEnd()->format('H:i'),
                    ]
                ];
            }
        }
        return new JsonResponse($json);
    }
}
