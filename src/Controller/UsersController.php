<?php

namespace App\Controller;

use App\Entity\Users;
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
}
