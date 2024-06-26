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
use App\Entity\Event;
use App\Entity\Notifications;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Service\EmailSenderService;
class PurchasesController extends AbstractController
{
    private $authController;

    public function __construct(AuthController $authController)
    {
        $this->authController = $authController;
    }

    #[Route('/purchases', name: 'app_purchases', methods: ['POST'])]
    public function index(Request $request, EntityManagerInterface $entityManager,EmailSenderService $mailerService): Response
    {
        $authResponse = $this->authController->authenticate($request, $entityManager);

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


        $textEmail = 'Compra realizada correctamente\n se han comprado los siguientes productos\n';

        $transaction = new Transactions();
        $transaction->setUserId($userId);
        $entityManager->persist($transaction);

        $totalPrice = 0;
        $products = [];

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
                $textEmail .= 'Se han comprado ' . $slots . ' boletos en la ' . $section->getDescription() . ' del evento '. $event->getTitle() .'\n';
                $products[] = [
                    'name' => $event->getTitle(),
                    'price' => $section->getPrice(),
                    'section' => $section->getDescription(),
                    'quantity' => $slots
                ];

                $totalPrice += $section->getPrice() * $slots;
            }
        }

        $subject = "Confirmación de compra";
        $templateId = 'x2p0347xk69gzdrn';



        $notification = new Notifications();
        $notification->setSubject($subject);
        $notification->setShortText("Compra realizada correctamente");
        $notification->setLongMessage("La compra de entradas se ha realizado correctamente para el usuario " . $user->getUsername() . ". Para visualizar la compra de entradas realizada, acceda a su correo electronico.");
        $notification->setIsReaded(false);
        $user->addNotification($notification);
        $entityManager->persist($notification);

        $entityManager->flush();

        $pdfResponse = $this->forward(PdfController::class.'::generatePdf', [
            'userEmail' => $user->getEmail(),
            'username' => $user->getUsername(),
            'totalPrice' => $totalPrice,
            'transactionId' => $transaction->getId(),
            'products' => $products
        ]);      
        
        $mailerService->sendEmailPurchase(
            $user->getEmail(),
            $user->getUsername(),
            $totalPrice,
            $transaction->getId(), 
            $subject,
            $templateId,
            $products,
            $pdfResponse->getContent()
        );
        return $this->json(['message' => 'Compra realizada correctamente'], 200);
    }

    #[Route('/purchaseShopCart', name: 'allow_add_to_car', methods: ['POST'])]
    public function allowAddToCar(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
    
        if (!isset($data['sub']) || empty($data['sections'])) {
            return $this->json(['error' => 'El campo "sub" y "sections" son requeridos y no pueden estar vacíos'], 400);
        }
    
        $authResponse = $this->authController->authenticate($request, $entityManager);
    
        if ($authResponse->getStatusCode() != Response::HTTP_OK) {
            return new JsonResponse($authResponse->getContent(), $authResponse->getStatusCode());
        }
    
        $user = $entityManager->getRepository(Users::class)->findOneBy([
            'sub' => $data['sub']
        ]);
    
        if ($user === null) {
            return $this->json(['error' => 'El usuario no existe'], 400);
        }
    
        $purchasesHistory = $entityManager->getRepository(PurchasesHistory::class)->findBy([
            'user' => $user
        ]);
    
        $totalEvents = 0;
        $totalSlots = [];
    
        foreach ($purchasesHistory as $purchase) {
            $eventId = $purchase->getSection()->getEvent()->getId();
            if (!isset($totalSlots[$eventId])) {
                $totalSlots[$eventId] = 0;
                $totalEvents++;
            }
            $totalSlots[$eventId] += $purchase->getSlots();
        }
    
        foreach ($data['sections'] as $section) {
            if (empty($section['id']) || empty($section['slots'])) {
                return $this->json(['error' => 'Los campos "id" y "slots" son requeridos y no pueden estar vacíos en cada sección'], 400);
            }
    
            $sectionEntity = $entityManager->getRepository(Section::class)->findOneBy([
                'id' => $section['id']
            ]);
    
            if ($sectionEntity === null) {
                return $this->json(['error' => 'La sección con ID ' . $section['id'] . ' no existe'], 400);
            }
    
            $eventId = $sectionEntity->getEvent()->getId();
            $slots = $section['slots'];
    
            if ($totalEvents >= 3) {
                return $this->json(['error' => 'El usuario ya ha comprado el máximo de eventos diferentes permitidos, que son 3'], 400);
            }
    
            if (isset($totalSlots[$eventId]) && $totalSlots[$eventId] + $slots > 5) {
                $event = $entityManager->getRepository(Event::class)->findOneBy([
                    'id' => $eventId
                ]);
                return $this->json(['error' => 'El usuario excede el límite de entradas permitidas máximas para el evento de '.$event->getTitle().', que son 5'], 400);
            }

            if (!isset($totalSlots[$eventId])) {
                $totalSlots[$eventId] = 0;
                $totalEvents++;
            }
            $totalSlots[$eventId] += $slots;
        }
    
        return $this->json(['message' => 'Agregado al carrito correctamente'], 200);
    }
    
}