<?php

namespace App\Scheduler\Handler;

use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use App\Entity\Users;
use Doctrine\ORM\EntityManagerInterface;

#[AsMessageHandler]
class RunMonthlyDrawHandler
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function __invoke(RunMonthlyDrawHandler $message)
    {
        $users = $this->entityManager->getRepository(Users::class)->findAll();
        $totalSlotsPerBuyer = 2;
        shuffle($users);
    }
}