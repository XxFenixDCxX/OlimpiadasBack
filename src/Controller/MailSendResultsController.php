<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\EmailSenderService;

class MailSendResultsController extends AbstractController
{
    private $mailerService;

    public function __construct(EmailSenderService $mailerService)
    {
        $this->mailerService = $mailerService;
    }

    #[Route('/send-email', name: 'send_email', methods: ['GET'])]
    public function sendEmail(): Response
    {
        $this->mailerService->sendEmail('noreplyolympics@gmail.com', 'Mohammed', 'Contenido del correo 1');

        return new Response('Correo electrónico enviado con éxito.');
    }
}
