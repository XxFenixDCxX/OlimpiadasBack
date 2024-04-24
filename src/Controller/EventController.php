<?php

namespace App\Controller;

use App\Entity\Event;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use App\Controller\AuthController;
use App\Service\AuthService;
use Symfony\Component\HttpFoundation\Request;

class EventController extends AbstractController
{

    private $authController;

    public function __construct(AuthController $authController)
    {
        $this->authController = $authController;
    }

    #[Route('/events', name: 'get_events', methods: ['GET'])]
    public function getAll(EntityManagerInterface $entityManager, Request $request): JsonResponse
    {
        $authResponse = $this->authController->authenticate($request, $entityManager);

        if ($authResponse->getStatusCode() != JsonResponse::HTTP_OK) {
            return new JsonResponse($authResponse->getContent(), $authResponse->getStatusCode());
        }

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

    #[Route('/events/{id}', name: 'get_especific_event', methods: ['GET'])]
    public function getEspecific(int $id, EntityManagerInterface $entityManager, Request $request): JsonResponse
    {
        $authResponse = $this->authController->authenticate($request, $entityManager);

        if ($authResponse->getStatusCode() != JsonResponse::HTTP_OK) {
            return new JsonResponse($authResponse->getContent(), $authResponse->getStatusCode());
        }

        $eventRepository = $entityManager->getRepository(Event::class);
        
        $event = $eventRepository->findOneBy(['id' => $id]);

        if (!$event) {
            return new JsonResponse(['message' => 'Evento no encontrado'], 404);
        }
        return $this->json($event->toArray());
    }
}
