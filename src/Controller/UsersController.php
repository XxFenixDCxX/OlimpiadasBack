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
    #[Route('/users/{sub}', name: 'get_especific_user', methods: ['GET'])]
    public function getEspecific(string $sub, EntityManagerInterface $entityManager): JsonResponse
    {
        $userRepository = $entityManager->getRepository(Users::class);
        
        $user = $userRepository->findOneBy(['sub' => $sub]);

        if (!$user) {
            return new JsonResponse(['message' => 'Usuario no encontrado'], JsonResponse::HTTP_NOT_FOUND);
        }
        return $this->json($user->toArray());
    }

    #[Route('/users', name: 'get_users', methods: ['GET'])]
    public function getAll(EntityManagerInterface $entityManager): JsonResponse
    {
        $usersRepository = $entityManager->getRepository(Users::class);
        $users = $usersRepository->findAll();

        if (empty($users)) {
            return $this->json(['error' => 'No hay usuarios'], 404);
        }

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

        if (!isset($data['sub']) || empty($data['sub']) || !isset($data['email']) || empty($data['email']) || !isset($data['username']) || empty($data['username'])) {
            return $this->json(['error' => 'El campo "sub", "email" y "username" es requerido y no puede estar vacío'], 400);
        }

        $existingUser = $entityManager->getRepository(Users::class)->findOneBy([
            'sub' => $data['sub']
        ]);

        if ($existingUser !== null) {
            return $this->json(['error' => 'El usuario ya existe'], 400);
        }

        $user = new Users();
        $user->setSub($data['sub']);
        $user ->setEmail($data['email']);
        $user ->setUsername($data['username']);

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
