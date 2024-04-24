<?php

namespace App\MessageHandler;
use Psr\Log\LoggerInterface;
use Symfony\Component\DateTime\DateTime;

use App\Service\LotteryService;
use App\Service\EmailSenderService;
use App\Service\LotteryNotificationsService;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Users;
use App\Message\ExecuteLottery;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class ExecuteLotteryHandler
{
    private $lotteryService;
    private $mailerService;
    private $entityManager;
    private $notificationService;
    public function __construct(private LoggerInterface $logger, LotteryService $lotteryService, EmailSenderService $mailerService, LotteryNotificationsService $notificationService , EntityManagerInterface $entityManager )
    {
        $this->lotteryService = $lotteryService;
        $this->mailerService = $mailerService;
        $this->entityManager = $entityManager;
        $this->notificationService = $notificationService;
    }

    public function __invoke(ExecuteLottery $message)
    {
        $currentDate = date('Y-m-d');
        $lotteryExecutedDate = '2024-03-30';


        $users = $this->entityManager->getRepository(Users::class)->findAll();
        $usersWithZones = 0 ; 
        foreach ($users as $user) {
            if (!$user->getZone()->isEmpty()) {
                $usersWithZones++;
                break; 
            }
        }  
        if ($currentDate == $lotteryExecutedDate || ( $currentDate > $lotteryExecutedDate  && $usersWithZones == 0)) {
        try {
                $this->lotteryService->executeLottery();
  
                $users = $this->entityManager->getRepository(Users::class)->findAll();
  
                foreach ($users as $user) {
                    $zones = $user->getZone();
                    $timeSlot1 = $zones[0]->getStart()->format('Y-m-d') . ' - ' . $zones[0]->getEnd()->format('Y-m-d');
                    $timeSlot2 = $zones[1]->getStart()->format('Y-m-d') . ' - ' . $zones[1]->getEnd()->format('Y-m-d');
                    $content = "Hola " . $user->getUsername() . ", ¡Felicidades! Como resultado de nuestra lotería, se te han asignado las siguientes franjas horarias para comprar las entradas: " . $timeSlot1 . " y " . $timeSlot2 . ". Si tienes alguna pregunta o necesitas cambiar tus franjas horarias, no dudes en ponerte en contacto con nosotros. Saludos, El equipo de administración";
                    $subject = "Resultado de la Lotería Olympics Paris";
                    $templateId = 'jpzkmgqzj2yg059v';
                    $this->mailerService->sendEmail($user->getEmail(), $user->getUsername(), $content,$subject,$templateId);
                    $this->notificationService->fillNotificationsForAllUsers();
                }
  
                $this->logger->info('Lottery executed and emails sent successfully!');
  
            } catch (\Exception $e) {
                $this->logger->warning('An error occurred while executing the lottery: ' . $e->getMessage());
              
            }
        } 

        


    }
}
