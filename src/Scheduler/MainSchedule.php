<?php
namespace App\Scheduler;

use App\Message\ExecuteLottery;
use Symfony\Component\Scheduler\Attribute\AsSchedule;
use Symfony\Component\Scheduler\RecurringMessage;
use Symfony\Component\Scheduler\Schedule;
use Symfony\Component\Scheduler\ScheduleProviderInterface;

#[AsSchedule]
class MainSchedule implements ScheduleProviderInterface
{
    public function getSchedule(): Schedule
    {

        return (new Schedule())->add(
            RecurringMessage::cron('0 0 * * *', new ExecuteLottery())
        );

        
    }
}