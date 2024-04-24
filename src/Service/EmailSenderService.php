<?php
// src/Service/MailerService.php
namespace App\Service;

use MailerSend\MailerSend;
use MailerSend\Helpers\Builder\Recipient;
use MailerSend\Helpers\Builder\EmailParams;
use MailerSend\Helpers\Builder\Personalization;

class EmailSenderService
{
    private $mailersend;

    public function __construct()
    {
        $this->mailersend = new MailerSend(['api_key' => 'mlsn.26483a8371b6493451901a0bb0cd3e35b7fcdee5f8fe80035222c0120a15a624']);
    }

    public function sendEmail( $to, $nameTo, $content , $subject , $templateId)
    {

        $from = 'info@trial-x2p0347y88p4zdrn.mlsender.net';
        $fromName = 'Olympics-noreply';

        $personalizationParams = [
            new Personalization($to, [
                    'name' => $nameTo,
                    'comment' => [
                        'content'=> $content                    
                    ],
            ])
        ];

        $recipients = [
            new Recipient($to , $nameTo),
        ];

        $emailParams = (new EmailParams())
            ->setFrom($from)
            ->setFromName($fromName)
            ->setRecipients($recipients)
            ->setSubject($subject)
            ->setTemplateId($templateId)
            ->setPersonalization($personalizationParams);

        $this->mailersend->email->send($emailParams);
    }


    public function sendEmailPurchase($to, $nameTo, $totalPrice, $orderNumber, $subject, $templateId, $products)
    {
        $from = 'info@trial-x2p0347y88p4zdrn.mlsender.net';
        $fromName = 'Olympics-noreply';
    
        $productDetails = [];
        foreach ($products as $product) {
            $productDetails[] = [
                'name' => $product['name'],
                'price' => $product['price'],
                'quantity' => $product['quantity'],
                'section' => $product['section']
            ];
        }
    
        $personalizationParams = [
            new Personalization($to, [
                'name' => $nameTo,
                'order' => [
                    'total' => $totalPrice,
                    'order_number' => $orderNumber
                ],
                'products' => $productDetails  
            ])
        ];
    
        $recipients = [
            new Recipient($to, $nameTo),
        ];
    
        $emailParams = (new EmailParams())
            ->setFrom($from)
            ->setFromName($fromName)
            ->setRecipients($recipients)
            ->setSubject($subject)
            ->setTemplateId($templateId)
            ->setPersonalization($personalizationParams);
    
        $this->mailersend->email->send($emailParams);
    }
}    
