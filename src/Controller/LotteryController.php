<?php
// src/Controller/LotteryController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use App\Service\LotteryService;

class LotteryController extends AbstractController
{
    private $lotteryService;

    public function __construct(LotteryService $lotteryService)
    {
        $this->lotteryService = $lotteryService;
    }

    #[Route('/execute-lottery', name: 'app_lottery' ,methods: ['GET'])]
    public function executeLottery(): JsonResponse
    {
        try {
            $this->lotteryService->executeLottery();

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
