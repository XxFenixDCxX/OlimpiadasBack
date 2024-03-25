<?php

namespace App\Controller;

use App\Entity\Zones;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class ZonesController extends AbstractController
{
    #[Route('/zones', name: 'get_zones', methods: ['GET'])]
    public function getAll(EntityManagerInterface $entityManager): JsonResponse
    {
        $zonesRepository = $entityManager->getRepository(Zones::class);
        $zones = $zonesRepository->findAll();

        $zonesArray = [];
        foreach ($zones as $zone) {
            $zonesArray[] = $zone->toArray();
        }
        return $this->json($zonesArray);
    }
}
