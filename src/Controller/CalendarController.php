<?php

namespace App\Controller;

use App\Entity\Session;
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
     * @return Response
     */
    #[Route('/calendar', name: 'app_lesson_calendar', methods: ['GET'])]
    public function calendar(): Response
    {
        $currentUser = $this->getUser();
        return $this->render('lesson/calendar.html.twig', [
            'currentUser' => $currentUser,
        ]);
    }
    /**
     * @author Alexandre Messuve <alexandre.messuves@gmail.com>
     * @param EntityManagerInterface $manager
     * @param Request $request
     * @param Session $session
     * @return JsonResponse|Response
     */
    #[Route('/calendar/lesson/{id}/edit', name: 'app_calendar_lessonedit' , methods: ['PUT'])]
    public function lessonEdit(EntityManagerInterface $manager, Request $request, Session $session): JsonResponse|Response
    {
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

