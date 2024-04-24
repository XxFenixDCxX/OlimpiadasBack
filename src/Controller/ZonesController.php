<?php

namespace App\Controller;

use App\Entity\Zones;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use App\Controller\AuthController;
use App\Service\AuthService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ZonesController extends AbstractController
{
    private $authController;
    private $authService;

    public function __construct(AuthController $authController, AuthService $authService)
    {
        $this->authController = $authController;
        $this->authService = $authService;
    }

    #[Route('/zones', name: 'get_zones', methods: ['GET'])]
    public function getAll(EntityManagerInterface $entityManager, Request $request): JsonResponse
    {
        $authResponse = $this->authController->authenticate($request);

        if ($authResponse->getStatusCode() != Response::HTTP_OK) {
            return new JsonResponse($authResponse->getContent(), $authResponse->getStatusCode());
        }

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
