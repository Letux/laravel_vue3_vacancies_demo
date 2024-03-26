<?php

namespace App\Events;

use App\Models\JobVacancy;
use Illuminate\Foundation\Events\Dispatchable;

final class JobCreatedEvent
{
    use Dispatchable;

    public function __construct(public JobVacancy $job)
    {
    }
}
