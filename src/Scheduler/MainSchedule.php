<?php
namespace App\Scheduler;

use App\Message\ExecuteLottery;
use Symfony\Component\Scheduler\Attribute\AsSchedule;
use Symfony\Component\Scheduler\RecurringMessage;
use Symfony\Component\Scheduler\Schedule;
use Symfony\Component\Scheduler\ScheduleProviderInterface;
use Symfony\Component\Scheduler\Trigger\CronExpression;
#[AsSchedule]
class MainSchedule implements ScheduleProviderInterface
{
    public function getSchedule(): Schedule
    {

        return (new Schedule())->add(
            RecurringMessage::cron('@daily', new ExecuteLottery())
        );

        
    }
}