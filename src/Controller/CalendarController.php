<?php

namespace App\Controller;

use App\Entity\Session;
use App\Repository\LessonRepository;
use App\Repository\PeriodRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CalendarController extends AbstractController
{
    /**
     * @author Alexandre Messuve <alexandre.messuves@gmail.com>
     * @param LessonRepository $lessonRepository
     * @param PeriodRepository $periodRepository
     * @return Response
     */
    #[Route('/calendar', name: 'app_lesson_calendar', methods: ['GET'])]
    public function calendar(LessonRepository $lessonRepository, PeriodRepository $periodRepository): Response
    {
        if($this->getUser() === null){
            $this->addFlash('error', 'Vous devez vous connecter pour acceder a ce contenu');
            return $this->redirectToRoute('app_login');
        }
        $period = $periodRepository->findOneBy(['currentPeriod' => true]);
        $currentUser = $this->getUser();
        if ($currentUser->getRoles() === ['ROLE_ADMIN', 'ROLE_USER']){
            $lessons = $lessonRepository->findBySession($period->getSession());
        }else{
            $lessons = $lessonRepository->findBy(['Teacher' => $currentUser , 'Period' => $period]);
        }

        return $this->render('lesson/calendar.html.twig', [
            'currentUser' => $currentUser,
            'lessons' => $lessons
        ]);
    }


    /**
     * @author Alexandre Messuve <alexandre.messuves@gmail.com>
     * @param EntityManagerInterface $manager
     * @param Request $request
     * @param LessonRepository $lessonRepository
     * @return Response|JsonResponse
     */
    #[Route('/calendar/session/add', name: 'app_calendar_sessionadd' , methods: ['POST'])]
    public function sessionAdd(EntityManagerInterface $manager, Request $request, LessonRepository $lessonRepository): Response|JsonResponse
    {
        if($this->getUser() === null){
            $this->addFlash('error', 'Vous devez vous connecter pour acceder a ce contenu');
            return $this->redirectToRoute('app_login');
        }
        $json = [];
        //Permet d'ajouter une session via le calendrier
        if ($request->isXmlHttpRequest()){
                $session = new Session();
                $lesson = $lessonRepository->findOneBy(['id' => $request->get('lesson')]);
                if (!$request->get('evtEnd')){
                    list($day, $month, $year) = explode("/",$request->get('evtStart'));
                    $date = date_create($month.'/'.$day.'/'.$year);
                    $session->setDate($date)
                            ->setHourStart(date_create($request->get('timeStart')))
                            ->setHourEnd(date_create($request->get('timeEnd')))
                            ->setDay($date->format('w'))
                            ->setLesson($lesson)
                            ->setLabel($lesson->getLabel());
                }else {
                    list($day, $month, $year) = explode("/",$request->get('evtStart'));
                    $start = date_create($month.'/'.$day.'/'.$year);
                    list($day, $month, $year) = explode("/",$request->get('evtStart'));
                    $end = date_create($month.'/'.$day.'/'.$year);
                    $date = date_create($start->format('Y-m-d'));
                    $timeStart = date_create($start->format('H:i:s'));
                    $timeEnd = date_create($end->format('H:i:s'));
                    $session->setDate($date)
                        ->setHourStart($timeStart)
                        ->setHourEnd($timeEnd)
                        ->setDay($date->format('w'))
                        ->setLabel($lesson->getLabel())
                        ->setLesson($lesson);
                }
                $manager->persist($session);
                $manager->flush();
            $json[] = ['response' => 'ok'];
            return new JsonResponse($json);
        }else{
            return new Response('error', 404);
        }



    }
    /**
     * @author Alexandre Messuve <alexandre.messuves@gmail.com>
     * @param EntityManagerInterface $manager
     * @param Request $request
     * @param Session $session
     * @return JsonResponse|Response
     */
    #[Route('/calendar/session/{id}/edit', name: 'app_calendar_sessionedit' , methods: ['PUT'])]
    public function sessionEdit(EntityManagerInterface $manager, Request $request, Session $session): JsonResponse|Response
    {
        if($this->getUser() === null){
            $this->addFlash('error', 'Vous devez vous connecter pour acceder a ce contenu');
            return $this->redirectToRoute('app_login');
        }
        //Permet de modifier une session via le calendar
        $json = [];
        if ($session->getLesson()->getTeacher() === $this->getUser() OR $this->getUser()->getRoles() === ['ROLE_ADMIN', 'ROLE_USER']){
            if ($request->isXmlHttpRequest()){
                $start = date_create($request->get('start'));
                $end = date_create($request->get('end'));
                $date = date_create($start->format('Y-m-d'));
                $timeStart = date_create($start->format('H:i:s'));
                $timeEnd = date_create($end->format('H:i:s'));
                $session->setDate($date)
                    ->setHourStart($timeStart)
                    ->setHourEnd($timeEnd);
                $manager->persist($session);
                $manager->flush();
                $json[] = ['response' => 'ok'];
                return new JsonResponse($json);
            }
        }

        return new Response('Error', 404);

    }
}

