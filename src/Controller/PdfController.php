<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use TCPDF;

class PdfController extends AbstractController
{
    #[Route('/generate-pdf', name: 'generate_pdf', methods: ['GET'])]
    public function generatePdf(): Response
    {
        $userEmail = 'correo@example.com';
        $username = 'Usuario Ejemplo';
        $totalPrice = '$100.00';
        $transactionId = '123456789';
        $subject = 'Detalles de la compra';
        $products = [
            ['name' => 'Producto 1', 'quantity' => 2, 'price' => '$50.00'],
            ['name' => 'Producto 2', 'quantity' => 3, 'price' => '$50.00'],
        ];
        
        $html = $this->renderView(
            'pdf/purchase_receipt.html.twig',
            [
                'userEmail' => $userEmail,
                'username' => $username,
                'totalPrice' => $totalPrice,
                'transactionId' => $transactionId,
                'subject' => $subject,
                'products' => $products,
            ]
        );

        // Crear el PDF
        $pdf = new TCPDF();
        $pdf->AddPage();
        $pdf->writeHTML($html, true, false, true, false, '');

        // Obtener el contenido del PDF y devolverlo como una respuesta
        $pdfContent = $pdf->Output('purchase_receipt.pdf', 'S');

        return new Response($pdfContent, 200, array(
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="purchase_receipt.pdf"'
        ));
    }
}
