<?php

namespace App\Listeners;

use App\Events\JobCreatedEvent;
use App\Exceptions\NotEnoughCoinsForJobCreationException;
use App\Services\UserService;
use Throwable;

final readonly class WithdrawCoinsForJobCreationListener
{
    public function __construct(private UserService $userService)
    {
    }

    /**
     * @throws Throwable|NotEnoughCoinsForJobCreationException
     */
    public function handle(JobCreatedEvent $event): void
    {
        $this->userService->decrementCoinsForJobCreation($event->job->user, $event->job);
    }
}
