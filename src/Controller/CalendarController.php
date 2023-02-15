<?php

namespace App\Controller;

use App\Entity\Calendar;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializationContext;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use JMS\Serializer\SerializerInterface as JMSSerializer;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CalendarController extends AbstractController
{
    #[Route('/api/calendar', name: 'add_event_calendar', methods:['POST'])]
    public function addEventCalendar(Calendar $calendar, SerializerInterface $serializer, Request $request, EntityManagerInterface $entityManager, ValidatorInterface $validator): JsonResponse
    {
        $calendarEvent = $serializer->deserialize($request->getContent(), Calendar::class, 'json', [AbstractNormalizer::OBJECT_TO_POPULATE => $calendar]);

        if ($calendarEvent) {
            $calendarEvent->setUser($this->getUser());
            $calendarEvent->setColor('#ad2121');
            $calendarEvent->setAllDay(true);

            $errorsCalendarEvent = $validator->validate($calendarEvent);

            if (count($errorsCalendarEvent) > 0) {
                return new JsonResponse($errorsCalendarEvent, Response::HTTP_BAD_REQUEST, []);
            }

            $entityManager->persist($calendarEvent);
            $entityManager->flush();

            return new JsonResponse('success', Response::HTTP_OK, []);
        }

        return new JsonResponse(null , Response::HTTP_BAD_REQUEST, []);
    }

    #[Route('/api/calendar', name: 'get_events_calendar', methods:['GET'])]
    public function getEventsCalendar(Calendar $calendar, JMSSerializer $JSMSerializer, Request $request, EntityManagerInterface $entityManager, ValidatorInterface $validator): JsonResponse
    {
        $allEvents = $entityManager->getRepository(Calendar::class)->findBy(['user' => $this->getUser()]);

        if ($allEvents) {
            $jsonAlEvents = $JSMSerializer->serialize($allEvents, 'json', SerializationContext::create()->setGroups(array('getCalendars')));

            return new JsonResponse($jsonAlEvents, Response::HTTP_OK, [], true);
        }
       
        return new JsonResponse(null , Response::HTTP_BAD_REQUEST, []);
    }
}
