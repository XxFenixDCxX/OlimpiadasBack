<?php

namespace App\Controller;

use App\Entity\Event;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class SectionsController extends AbstractController
{
    #[Route('/sections/{id}', name: 'get_especific_event_sections', methods: ['GET'])]
    public function getEspecific(int $id, EntityManagerInterface $entityManager): JsonResponse
    {
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
