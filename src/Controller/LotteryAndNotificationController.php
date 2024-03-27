<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use App\Service\LotteryService;
use App\Service\EmailSenderService;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Users;

class LotteryAndNotificationController extends AbstractController
{
    private $lotteryService;
    private $mailerService;
    private $entityManager;

    public function __construct(LotteryService $lotteryService, EmailSenderService $mailerService, EntityManagerInterface $entityManager)
    {
        $this->lotteryService = $lotteryService;
        $this->mailerService = $mailerService;
        $this->entityManager = $entityManager;
    }

    #[Route('/lottery/and/notification', name: 'app_lottery_and_notification')]
    public function index(): JsonResponse
    {
        try {
            $this->lotteryService->executeLottery();

            $users = $this->entityManager->getRepository(Users::class)->findAll();

            foreach ($users as $user) {
                $zones = $user->getZone();
                $timeSlot1 = $zones[0]->getStart()->format('Y-m-d') . ' - ' . $zones[0]->getEnd()->format('Y-m-d');
                $timeSlot2 = $zones[1]->getStart()->format('Y-m-d') . ' - ' . $zones[1]->getEnd()->format('Y-m-d');
                $content = "Hola " . $user->getUsername() . ", ¡Felicidades! Como resultado de nuestra lotería, se te han asignado las siguientes franjas horarias para comprar las entradas: " . $timeSlot1 . " y " . $timeSlot2 . ". Si tienes alguna pregunta o necesitas cambiar tus franjas horarias, no dudes en ponerte en contacto con nosotros. Saludos, El equipo de administración";

                $this->mailerService->sendEmail($user->getEmail(), $user->getUsername(), $content);
            }

            return $this->json([
                'message' => 'Lottery executed and emails sent successfully!'
            ]);
        } catch (\Exception $e) {
            return $this->json([
                'message' => 'An error occurred while executing the lottery: ' . $e->getMessage()
            ], 500);
        }
    }
}
