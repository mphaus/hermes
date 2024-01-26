<?php

namespace App\Enums;

enum JobStatus: int
{
    case Open = 0;
    case Provisional = 1;
    case Reserved = 5;
    case Active = 20;
    case Completed = 40;
    case Cancelled = 50;
    case Lost = 60;
    case Dead = 70;
    case Postponed = 80;
}
