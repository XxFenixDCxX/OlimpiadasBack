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
use Symfony\Component\HttpFoundation\Response;

class SectionsController extends AbstractController
{
    private $authController;

    public function __construct(AuthController $authController)
    {
        $this->authController = $authController;
    }
    
    #[Route('/sections/{id}', name: 'get_especific_event_sections', methods: ['GET'])]
    public function getEspecific(int $id, EntityManagerInterface $entityManager, Request $request): JsonResponse
    {
        $authResponse = $this->authController->authenticate($request, $entityManager);

        if ($authResponse->getStatusCode() != Response::HTTP_OK) {
            return new JsonResponse($authResponse->getContent(), $authResponse->getStatusCode());
        }

        $eventRepository = $entityManager->getRepository(Event::class);
        
        $event = $eventRepository->findOneBy(['id' => $id]);

        $sections = $event->getSections();

        if (empty($sections)) {
            return new JsonResponse(['message' => 'Secciones no encontradas'], 404);
        }

        $sectionsArray = [];
        foreach ($sections as $section) {
            $sectionsArray[] = $section->toArray();
        }
        return $this->json($sectionsArray);
    }
}
