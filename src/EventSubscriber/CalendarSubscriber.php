<?php
// src/EventSubscriber/CalendarSubscriber.php
namespace App\EventSubscriber;

use App\Entity\Lesson;
use App\Repository\LessonRepository;
use CalendarBundle\CalendarEvents;
use CalendarBundle\Entity\Event;
use CalendarBundle\Event\CalendarEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class CalendarSubscriber implements EventSubscriberInterface
{
    public function __construct(private LessonRepository $lessonRepository, private UrlGeneratorInterface $router){

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
        $lessons = $this->lessonRepository->findAll();

        foreach ($lessons as $lesson){
            $lessonEvent = new Event(
                $lesson->getLabel(),
                $lesson->getTimeStart(),
                $lesson->getTimeEnd(),
            );
            $lessonEvent->setOptions([
                'timeStart' => $lesson->getHoursStart()->format('H:i'),
                'timeEnd' => $lesson->getHoursEnd()->format('H:i'),
                'daysOfWeek' => $lesson->getTimeStart()->format('w'),
                'startRecur' => $lesson->getTimeStart()->format('c'),
                'endRecur' => $lesson->getTimeEnd()->format('Y-m-d'),
                ]);
            $lessonEvent->addOption(
                'url',
                $this->router->generate('lesson.modif', [
                    'id' => $lesson->getId(),
                ])
            );
            $calendar->addEvent($lessonEvent);
        }
    }
}