<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class OpportunityItems extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'opportunityitems';
    }
}
