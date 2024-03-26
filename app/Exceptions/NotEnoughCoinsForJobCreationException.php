<?php

namespace App\Exceptions;

use App\Models\JobVacancy;
use App\Models\User;
use Exception;

final class NotEnoughCoinsForJobCreationException extends Exception
{
    public function __construct(User $user, JobVacancy $job)
    {
        parent::__construct('Not enough coins for job creation. User: ' . $user->id . ' Job: ' . $job->id . ' User coins: ' . $user->coins);
    }
}
