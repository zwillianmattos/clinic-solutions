<?php

namespace App\EventSubscriber;

use App\Repository\AppointmentRepository;
use CalendarBundle\CalendarEvents;
use CalendarBundle\Entity\Event;
use CalendarBundle\Event\CalendarEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class CalendarSubscriber implements EventSubscriberInterface
{
    private $appointmentRepository;
    private $router;

    public function __construct(
        AppointmentRepository $appointmentRepository,
        UrlGeneratorInterface $router
    ) {
        $this->appointmentRepository = $appointmentRepository;
        $this->router = $router;
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

        $appointments = $this->appointmentRepository
            ->createQueryBuilder('booking')
            ->where('booking.beginAt BETWEEN :start and :end OR booking.endAt BETWEEN :start and :end')
            ->setParameter('start', $start->format('Y-m-d H:i:s'))
            ->setParameter('end', $end->format('Y-m-d H:i:s'))
            ->getQuery()
            ->getResult()
        ;

        foreach ($appointments as $appointment) {
            $appointmentEvent = new Event(
                $appointment->getTitle(),
                $appointment->getBeginAt(),
                $appointment->getEndAt() // If the end date is null or not defined, a all day event is created.
            );

            $appointmentEvent->setOptions([
                'backgroundColor' => 'red',
                'borderColor' => 'red',
            ]);
            
            $appointmentEvent->addOption(
                'url',
                $this->router->generate('app_appointment_show', [
                    'id' => $appointment->getId(),
                ])
            );
            
            $calendar->addEvent($appointmentEvent);
        }
        
    }
}