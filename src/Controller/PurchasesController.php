<?php

namespace App\Controller;

use App\Entity\PurchasesHistory;
use App\Entity\Section;
use App\Entity\Transactions;
use App\Entity\Users;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\AuthService;
use App\Controller\AuthController;
use Symfony\Component\HttpFoundation\JsonResponse;

class PurchasesController extends AbstractController
{
    private $authController;
    private $authService;

    public function __construct(AuthController $authController, AuthService $authService)
    {
        $this->authController = $authController;
        $this->authService = $authService;
    }

    #[Route('/purchases', name: 'app_purchases', methods: ['POST'])]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $authResponse = $this->authController->authenticate($request);

        if ($authResponse->getStatusCode() != Response::HTTP_OK) {
            return new JsonResponse($authResponse->getContent(), $authResponse->getStatusCode());
        }

        $content = $request->getContent();
        $requestData = json_decode($content, true);

        if ($requestData === null || !isset($requestData['sections']) || !isset($requestData['userId'])) {
            return $this->json(['error' => 'No se han pasado los parámetros correctamente'], 400);
        }
        
        $sections = $requestData['sections'];
        $userId = (string)$requestData['userId'];

        $usersRepository = $entityManager->getRepository(Users::class);
        $user = $usersRepository->findOneBy(['sub' => $userId]);
        if($user === null)
            return $this->json(['error' => 'No se ha encontrado el usuario'], 404);

        $emailTo = $user->getEmail();
        $nameTo = $user->getUsername();
        $textEmail = 'Compra realizada correctamente\n se han comprado los siguientes productos\n';

        $transaction = new Transactions();
        $transaction->setUserId($userId);
        $entityManager->persist($transaction);

        foreach ($sections as $section) {
            foreach ($section as $sectionDetails) {
                $sectionID = $sectionDetails['id'];
                $slots = $sectionDetails['slots'];
                $sectionRepository = $entityManager->getRepository(Section::class);
                $section = $sectionRepository->findOneBy(['id' => $sectionID]);
                if ($section === null) {
                    return $this->json(['error' => 'No se ha encontrado la sección'], 404);
                }
                if($slots > $section->getSlots())
                    return $this->json(['error' => 'No hay suficientes slots disponibles'], 400);
                $sectionSlots = $section->getSlots() - $slots;
                $section->setSlots($sectionSlots);
                $entityManager->persist($section);
                $purchaseHistory = new PurchasesHistory();
                $purchaseHistory->setUser($user);
                $purchaseHistory->setSection($section);
                $purchaseHistory->setSlots($slots);
                $purchaseHistory->setDate(new \DateTime('now', new \DateTimeZone('Europe/Madrid')));
                $purchaseHistory->setTransaction($transaction);
                $entityManager->persist($purchaseHistory);
                $eventId = $section->getEvent()->getId();
                $eventRepository = $entityManager->getRepository(Event::class);
                $event = $eventRepository->findOneBy(['id' => $eventId]);
                $textEmail .= 'Se han comprado ' . $slots . ' voletos en la ' . $section->getDescription() . ' del evento '. $event->getTitle() .'\n';
            }
        }

        $entityManager->flush();
        return $this->json(['message' => 'Compra realizada correctamente'], 200);
    }
}