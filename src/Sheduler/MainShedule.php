<?php
use Symfony\Component\Scheduler\RecurringMessage;
use Symfony\Component\Scheduler\Schedule;
use Symfony\Component\Scheduler\ScheduleProviderInterface;
use Symfony\Component\Scheduler\Attribute\AsSchedule;
use App\Message\LogHello;

#[AsSchedule]
class MainSchedule implements ScheduleProviderInterface
{
    public function getSchedule(): Schedule
    {
        return (new Schedule())->add(
            RecurringMessage::every('4 seconds', new LogHello(4)),
            RecurringMessage::every('3 seconds', new LogHello(3)),
        );
    }
}