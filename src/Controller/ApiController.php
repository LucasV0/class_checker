<?php

namespace App\Controller;

use App\Entity\Period;
use App\Entity\Session;
use App\Repository\LessonRepository;
use App\Repository\PeriodRepository;
use App\Repository\SessionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use function Symfony\Component\Translation\t;

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
            $json['session'] = $session->getSession();
            $tablesson = [];
            foreach ($lessons as $lesson){
                $tablesson[] =
                      [
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
                    ];
            }
            $json['lesson'] = $tablesson;
        }
        return new JsonResponse($json);
    }

    #[Route('/api/lesson/{id}/edit', name: 'app_api_edit' , methods: ['PUT'])]
    public function lessonEdit(EntityManagerInterface $manager, Request $request, Session $session): JsonResponse
    {
        $json = [];
            if ($request->isXmlHttpRequest()){
                $start = date_create(strstr($request->get('start')," (", true));
                $end = date_create(strstr($request->get('end')," (", true));
                $date = date_create($start->format('Y-m-d'));
                $hoursStart = $start->format('H') - 2;
                $hoursEnd = $end->format('H') -2;
                $timeStart = date_create($start->format($hoursStart.':i:s'));
                $timeEnd = date_create($end->format($hoursEnd.':i:s'));
                $session->setDate($date)
                        ->setHourStart($timeStart)
                        ->setHourEnd($timeEnd);
                $manager->persist($session);
                $manager->flush();
                $json[] = ['response' => 'ok'];
            }else{
                $json[] = ['response' => 'error'];
            }

            return new JsonResponse($json);
    }
}
