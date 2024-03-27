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

    public function sendEmail( $to, $nameTo, $content)
    {

        $from = 'info@trial-x2p0347y88p4zdrn.mlsender.net';
        $fromName = 'Olympics-noreply';
        $subject = 'Resultado de la Lotería Olympics Paris';
        $templateId = 'jpzkmgqzj2yg059v';
        
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
}
