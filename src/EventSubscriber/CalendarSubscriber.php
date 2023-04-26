<?php
// src/EventSubscriber/CalendarSubscriber.php
namespace App\EventSubscriber;

use App\Entity\Lesson;
use App\Repository\LessonRepository;
use App\Repository\SessionRepository;
use CalendarBundle\CalendarEvents;
use CalendarBundle\Entity\Event;
use CalendarBundle\Event\CalendarEvent;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class CalendarSubscriber extends AbstractController implements EventSubscriberInterface
{
    public function __construct(private SessionRepository $sessionRepository, private UrlGeneratorInterface $router){

    }
    public static function getSubscribedEvents()
    {
        return [
            CalendarEvents::SET_DATA => 'onCalendarSetData',
        ];
    }

    public function onCalendarSetData(CalendarEvent $calendar)
    {
        $start = $calendar->getStart();
        $end = $calendar->getEnd();
        $filters = $calendar->getFilters();
        $sessions = $this->sessionRepository->findAll();

        foreach ($sessions as $session){
            if ($session->getLesson()->getTeacher() === $this->getUser()){
                if ($session->getDate() < date_create()){
                    $background = '#dddddd';
                    $textColor = '#0c1c0b';
                }else{
                    $background = '#83d75e';
                    $textColor = '#0c1c0b';
                }
                if ($session->getDate()->format('Y-m-d') === date_create()->format('Y-m-d')){
                    $background = '#1666ee';
                    $textColor = '#eeeeee';
                }
            }else{
                if ($session->getDate() < date_create()){
                    $background = '#dddddd';
                    $textColor = '#0c1c0b';
                }else{
                    $background = '#e96944';
                    $textColor = '#0c1c0b';
                }
                if ($session->getDate()->format('Y-m-d') === date_create()->format('Y-m-d')){
                    $background = '#5091cc';
                    $textColor = '#eeeeee';
                }
            }

            $date = $session->getDate()->format('Y-m-d');
            $timeStart = $session->getHourStart()->format('H:i');
            $startDate = date_create($date.' '.$timeStart, new \DateTimeZone('Europe/Paris'));
            $timeEnd = $session->getHourEnd()->format('H:i');
            $endDate = date_create($date.' '.$timeEnd, new \DateTimeZone('Europe/Paris'));
            $lessonEvent = new Event(
                $session->getLabel(),
                $startDate,
                $endDate,
            );
            $lessonEvent->setOptions(
                [
                    'id' => $session->getId(),
                    'textColor' => $textColor,
                    'backgroundColor' => $background,

                    ]
            );
            $calendar->addEvent($lessonEvent);
        }
    }
}