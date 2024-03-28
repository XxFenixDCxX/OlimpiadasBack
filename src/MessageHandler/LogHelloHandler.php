<?php
// src/MessageHandler/SendLotteryNotificationHandler.php
namespace App\MessageHandler;
use Psr\Log\LoggerInterface;

use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use App\Message\LogHello;

#[AsMessageHandler]
final class LogHelloHandler
{
    public function __construct(private LoggerInterface $logger)
    {
    }
    public function __invoke(LogHello $message)
    {
        $this->logger->warning(str_repeat('🎸', $message->length).' '.$message->length);
    }
}
