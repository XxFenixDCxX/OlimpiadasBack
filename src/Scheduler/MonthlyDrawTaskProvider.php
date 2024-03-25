<?php
namespace App\Scheduler;

use App\Scheduler\Message\LotterySlots;
use Symfony\Component\Scheduler\Attribute\AsSchedule;
use Symfony\Component\Scheduler\Schedule;
use Symfony\Component\Scheduler\ScheduleProviderInterface;
use Symfony\Component\Console\Command\Command;


#[AsSchedule]
class LotteryTaskProvider implements ScheduleProviderInterface
{
    public function getSchedule(): Schedule
    {
        return new Schedule();
    }
}

