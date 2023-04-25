<?php
// src/EventSubscriber/CalendarSubscriber.php
namespace App\EventSubscriber;

use App\Entity\Lesson;
use App\Repository\LessonRepository;
use App\Repository\SessionRepository;
use CalendarBundle\CalendarEvents;
use CalendarBundle\Entity\Event;
use CalendarBundle\Event\CalendarEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class CalendarSubscriber implements EventSubscriberInterface
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
            $startDate = $session->getDate()->format('Y-m-d');
            $timeStart = $session->getHourStart()->format('H:i');
            $start = date_create($startDate.' '.$timeStart, new \DateTimeZone('Europe/Paris'));
            $timeEnd = $session->getHourEnd()->format('H:i');
            $end = date_create($startDate.' '.$timeEnd, new \DateTimeZone('Europe/Paris'));
            $lessonEvent = new Event(
                $session->getLabel(),
                $start,
                $end,
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