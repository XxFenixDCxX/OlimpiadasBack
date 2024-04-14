<?php
namespace App\Service;

use App\Entity\Notifications;
use App\Entity\Users;
use Doctrine\ORM\EntityManagerInterface;

class LotteryNotificationsService
{
    private $entityManager;

    public function __construct(EntityManagerInterface  $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function createNotification($user, $subject, $shortText, $longMessage)
    {
        $notification = new Notifications();
        $notification->setSubject($subject);
        $notification->setShortText($shortText);
        $notification->setLongMessage($longMessage);
        $notification->setIsReaded(false);

        $user->addNotification($notification);
        $this->entityManager->persist($notification);
        $this->entityManager->flush();

        return $notification;
    }

    public function fillNotificationsForAllUsers()
    {
        $users = $this->entityManager->getRepository(Users::class)->findAll();

        foreach ($users as $user) {
            $zones = $user->getZone();
            $timeSlot1 = $zones[0]->getStart()->format('Y-m-d') . ' - ' . $zones[0]->getEnd()->format('Y-m-d');
            $timeSlot2 = $zones[1]->getStart()->format('Y-m-d') . ' - ' . $zones[1]->getEnd()->format('Y-m-d');
            $content = "Hola " . $user->getUsername() . ", ¡Felicidades! Como resultado de nuestra lotería, se te han asignado las siguientes franjas horarias para comprar las entradas: " . $timeSlot1 . " y " . $timeSlot2 . " .";

            $this->createNotification($user, 'Resultado de la Lotería Olympics Paris', '¡Felicidades!', $content);
        }

    }
}


