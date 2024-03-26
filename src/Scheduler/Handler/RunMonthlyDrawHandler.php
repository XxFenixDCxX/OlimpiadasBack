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
        $this->executeLotteryAction();
    }

    public function executeLotteryAction()
    {
        $users = $this->entityManager->getRepository(Users::class)->findAll();
        $totalUsers = count($users);
    
        $zone1Ids = [1, 2, 3, 4];
        $zone2Ids = [5, 6, 7, 8];
    
        $usersPerZone = $totalUsers / (count($zone1Ids) + count($zone2Ids));
    
        shuffle($users);
    
        for ($i = 0; $i < $totalUsers; $i++) {
            $user = $users[$i];
    
            $zone1Id = $zone1Ids[intval($i / $usersPerZone) % count($zone1Ids)];
            $zone2Id = $zone2Ids[intval($i / $usersPerZone) % count($zone2Ids)];
    
            $user->addZone($zone1Id);
            $user->addZone($zone2Id);
    
            $this->entityManager->persist($user);
        }
        $this->entityManager->flush();
    }
    

    

}