<?php

namespace App\Message;

final class LogHello
{
    public function __construct(public int $length)
    {
    }
}
