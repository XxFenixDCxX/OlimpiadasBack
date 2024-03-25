<?php
// src/Scheduler/Handler/LotterySlotsHandler.php
namespace App\Scheduler\Handler;

use App\Scheduler\Message\LotterySlots;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Buyer;
use App\Entity\Event;
use App\Entity\Ticket;

#[AsMessageHandler]
class LotterySlotsHandler
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function __invoke(LotterySlots $message)
    {
        $buyers = $this->entityManager->getRepository(Users::class)->findAll();
        // Calcular el número de slots disponibles para el sorteo
        $totalSlots = 4; // Número total de slots para compradores
        $slotsPerWeek = 1; // Número de slots disponibles por semana
        $totalWeeks = 4; // Número total de semanas para el sorteo
        $totalBuyers = count($buyers);
        $slots = [];

        // Verificar si hay suficientes compradores para el sorteo
        if ($totalBuyers >= $totalSlots * $totalWeeks) {
            // Dividir a los compradores en slots
            shuffle($buyers); // Barajar aleatoriamente los compradores
            for ($i = 0; $i < $totalSlots * $totalWeeks; $i++) {
                $slotNumber = $i % $totalSlots + 1; // Número de slot (1, 2, 3 o 4)
                $weekNumber = (int) ($i / $totalSlots) + 1; // Número de semana (1, 2, 3 o 4)
                $buyer = $buyers[$i]; // Obtener el comprador para este slot
                $slots[$weekNumber][] = ['buyer' => $buyer, 'slot' => $slotNumber];
            }

            // Asignar slots a los compradores
            foreach ($slots as $weekNumber => $weekSlots) {
                foreach ($weekSlots as $slotData) {
                    $buyer = $slotData['buyer'];
                    $slotNumber = $slotData['slot'];

                    // Crear un nuevo ticket y asignarlo al comprador
                    $ticket = new Ticket();
                    $ticket->setBuyer($buyer);
                    $ticket->setWeek($weekNumber);
                    $ticket->setSlot($slotNumber);

                    // Guardar el ticket en la base de datos
                    $this->entityManager->persist($ticket);
                }
            }

            // Ejecutar el flush para guardar los cambios en la base de datos
            $this->entityManager->flush();

            // Notificar el resultado del sorteo
            // Puedes implementar la lógica para notificar a los compradores aquí
        } else {
            // No hay suficientes compradores para el sorteo
            // Puedes implementar la lógica para manejar esta situación aquí
        }
    }
}
