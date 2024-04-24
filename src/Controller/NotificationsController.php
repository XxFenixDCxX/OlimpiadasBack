<?php

namespace App\Controller;

use App\Entity\Notifications;
use App\Entity\Users;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use App\Service\AuthService;
use App\Controller\AuthController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class NotificationsController extends AbstractController
{
    private $authController;
    private $authService;

    public function __construct(AuthController $authController, AuthService $authService)
    {
        $this->authController = $authController;
        $this->authService = $authService;
    }
    
    #[Route('/notifications/{sub}', name: 'get_especific_user_notifications', methods: ['GET'])]
    public function getEspecificUserNotification(string $sub, EntityManagerInterface $entityManager, Request $request): JsonResponse
    {
        $authResponse = $this->authController->authenticate($request);

        if ($authResponse->getStatusCode() != Response::HTTP_OK) {
            return new JsonResponse($authResponse->getContent(), $authResponse->getStatusCode());
        }

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
    public function getEspecificNotification(int $id, EntityManagerInterface $entityManager, Request $request): JsonResponse
    {
        $authResponse = $this->authController->authenticate($request);

        if ($authResponse->getStatusCode() != Response::HTTP_OK) {
            return new JsonResponse($authResponse->getContent(), $authResponse->getStatusCode());
        }

        $notificationRepository = $entityManager->getRepository(Notifications::class);
        $notification = $notificationRepository->findOneBy(['id' => $id]);

        if (!$notification) {
            return new JsonResponse(['message' => 'Notificacion no encontrada'], 404);
        }

        return $this->json($notification->toArray());
    }

    #[Route('/notification/mark-as-read/{id}', name: 'mark_notification_as_read', methods: ['PUT'])]
    public function markNotificationAsRead(int $id, EntityManagerInterface $entityManager, Request $request): JsonResponse
    {
        $authResponse = $this->authController->authenticate($request);

        if ($authResponse->getStatusCode() != Response::HTTP_OK) {
            return new JsonResponse($authResponse->getContent(), $authResponse->getStatusCode());
        }

        $notificationRepository = $entityManager->getRepository(Notifications::class);
        $notification = $notificationRepository->find($id);

        if (!$notification) {
            return new JsonResponse(['message' => 'Notificación no encontrada'], 404);
        }
        $notification->setIsReaded(true);
        $entityManager->flush();

        return new JsonResponse(['message' => 'Notificación marcada como leída'], 200);
    }
}
