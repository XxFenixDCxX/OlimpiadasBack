<?php

namespace App\Controller;

use App\Entity\Users;
use App\Entity\Zones;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class UsersController extends AbstractController
{
    #[Route('/users', name: 'get_users', methods: ['GET'])]
    public function getAll(EntityManagerInterface $entityManager): JsonResponse
    {
        $usersRepository = $entityManager->getRepository(Users::class);
        $users = $usersRepository->findAll();

        $usersArray = [];
        foreach ($users as $user) {
            $usersArray[] = $user->toArray();
        }
        return $this->json($usersArray);
    }

    #[Route('/users', name: 'create_users', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['sub']) || empty($data['sub'])) {
            return $this->json(['error' => 'El campo "sub" es requerido y no puede estar vacío'], 400);
        }

        $existingUser = $entityManager->getRepository(Users::class)->findOneBy([
            'sub' => $data['sub']
        ]);

        if ($existingUser !== null) {
            return $this->json(['error' => 'El usuario ya existe'], 400);
        }

        $user = new Users();
        $user->setSub($data['sub']);

        try {
            $entityManager->persist($user);
            $entityManager->flush();
            return $this->json(['message' => 'Usuario creado correctamente'], 201);
        } catch (\Exception $e) {
            return $this->json(['error' => 'Error al crear el usuario'], 500);
        }
    }

    #[Route('/users/{sub}', name: 'update_users_zones', methods: ['PUT'])]
    public function update(string $sub, Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $user = $entityManager->getRepository(Users::class)->findOneBy(['sub' => $sub]);

        if (!$user) {
            return $this->json(['error' => 'Usuario no encontrado.'], 404);
        }

        $data = json_decode($request->getContent(), true);

        if (!isset($data['zones'])) {
            return $this->json(['error' => 'Las zonas son requeridas.'], 400);
        }

        $zoneIds = $data['zones'];
        $user->getZone()->clear();

        foreach ($zoneIds as $zoneId) {
            $zone = $entityManager->getRepository(Zones::class)->find($zoneId);
            if ($zone) {
                $user->addZone($zone);
            }
        }

        try {
            $entityManager->flush();
            return $this->json(['message' => 'Zonas actualizadas correctamente para el usuario.'], 200);
        } catch (\Exception $e) {
            return $this->json(['error' => 'Error al actualizar las zonas del usuario.'], 500);
        }
    }
}
