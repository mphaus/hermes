<?php

namespace App\Enums;

enum JobState: int
{
    case Enquiry = 0;
    case Draft = 1;
    case Quotation = 2;
    case Order = 3;
}
