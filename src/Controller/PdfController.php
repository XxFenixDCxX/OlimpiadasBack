<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use TCPDF;

class PdfController extends AbstractController
{
    public function generatePdf($userEmail, $username, $totalPrice, $transactionId, $products): Response
    {
        $subject = 'Detalles de la compra';
        
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
