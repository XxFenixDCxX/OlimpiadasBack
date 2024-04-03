<?php

namespace App\Controller;

use App\Entity\Notifications;
use App\Entity\Users;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class NotificationsController extends AbstractController
{
    #[Route('/notifications/{sub}', name: 'get_especific_user_notifications', methods: ['GET'])]
    public function getEspecificUserNotification(string $sub, EntityManagerInterface $entityManager): JsonResponse
    {
        $userRepository = $entityManager->getRepository(Users::class);
        $user = $userRepository->findOneBy(['sub' => $sub]);

        if (!$user) {
            return new JsonResponse(['message' => 'Usuario no encontrado'], 404);
        }
        $notifications = $user->getNotifications();

        if ($notifications === null || count($notifications) === 0) {
            return new JsonResponse(['message' => 'No hay notificaciones'], 500);
        }


        $notificationsArray = [];

        foreach ($notifications as $notification) {
            $notificationsArray[] = $notification->toArray();
        }

        return $this->json($notificationsArray);
    }
    #[Route('/notification/{id}', name: 'get_especific_notifications', methods: ['GET'])]
    public function getEspecificNotification(int $id, EntityManagerInterface $entityManager): JsonResponse
    {
        $notificationRepository = $entityManager->getRepository(Notifications::class);
        $notification = $notificationRepository->findOneBy(['id' => $id]);

        if (!$notification) {
            return new JsonResponse(['message' => 'Notificacion no encontrada'], 404);
        }

        return $this->json($notification->toArray());
    }
}
