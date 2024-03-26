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

        if (empty($zones)) {
            throw $this->createNotFoundException('No hay zonas');
        }

        $zonesArray = array_map(function (Zones $zone) {
            return $zone->toArray();
        }, $zones);

        return $this->json($zonesArray);
    }
}