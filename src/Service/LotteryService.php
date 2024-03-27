<?php
// src/Service/LotteryService.php
namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Users;
use App\Entity\Zones;

class LotteryService
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function executeLottery()
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

            $zone1 = $this->entityManager->getRepository(Zones::class)->find($zone1Id);
            $zone2 = $this->entityManager->getRepository(Zones::class)->find($zone2Id);
            
            if (!$zone1 || !$zone2) {
                throw new \Exception("Una de las zonas no existe.");
            }
            
            $user->addZone($zone1);
            $user->addZone($zone2);

            $this->entityManager->persist($user);
        }

        $this->entityManager->flush();
    }
}
