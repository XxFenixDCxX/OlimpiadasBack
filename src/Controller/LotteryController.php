<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Users;
use App\Entity\Zones;

class LotteryController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    #[Route('/execute-lottery', name: 'app_lottery' ,methods: ['GET'])]
    public function executeLottery(): JsonResponse
    {
        try {
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
                $user->addZone($zone1);
                $user->addZone($zone2);
    
                $this->entityManager->persist($user);
            }
            $this->entityManager->flush();
    
            return $this->json([
                'message' => 'Lottery executed successfully!'
            ]);
        } catch (\Exception $e) {
            return $this->json([
                'message' => 'An error occurred while executing the lottery: ' . $e->getMessage()
            ], 500);
        }
    }
    
}
