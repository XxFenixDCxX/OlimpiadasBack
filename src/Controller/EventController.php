<?php

namespace App\Controller;

use App\Entity\Event;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class EventController extends AbstractController
{
    #[Route('/events', name: 'get_events', methods: ['GET'])]
    public function getAll(EntityManagerInterface $entityManager): JsonResponse
    {
        $eventRepository = $entityManager->getRepository(Event::class);
        $events = $eventRepository->findAll();

        if (empty($events)) {
            return $this->json(['error' => 'No hay eventos'], 404);
        }

        $eventsArray = [];
        foreach ($events as $event) {
            $eventsArray[] = $event->toArray();
        }
        return $this->json($eventsArray);
    }

    #[Route('/event/{id}', name: 'get_especific_event', methods: ['GET'])]
    public function getEspecific(int $id, EntityManagerInterface $entityManager): JsonResponse
    {
        $eventRepository = $entityManager->getRepository(Event::class);
        
        $event = $eventRepository->findOneBy(['id' => $id]);

        if (!$event) {
            return new JsonResponse(['message' => 'Evento no encontrado'], 404);
        }
        return $this->json($event->toArray());
    }
}
