<?php

namespace App\Services;

use App\Exceptions\NotEnoughCoinsForJobCreationException;
use App\Models\JobVacancy;
use App\Models\User;
use App\Repositories\JobsRepository;
use App\Repositories\UserRepository;
use Throwable;

final readonly class UserService
{
    public function __construct(
        private JobsRepository $jobsRepository,
        private UserRepository $userRepository,
    ) {}

    public function hasCoinsForJobCreation(int $userCoins): bool
    {
        return $userCoins >= config('jobs.coins_for_job_creation');
    }

    public function reachedLimitForJobCreation(int $userId): bool
    {
        return $this->jobsRepository->count24hours($userId) >= config('jobs.max_jobs_per_day');
    }

    /**
     * @throws NotEnoughCoinsForJobCreationException|Throwable
     */
    public function decrementCoinsForJobCreation(User $user, JobVacancy $job): void
    {
        throw_if(!$this->hasCoinsForJobCreation($user->coins), new NotEnoughCoinsForJobCreationException($user, $job));

        $this->userRepository->decrementCoins($user->id, config('jobs.coins_for_job_creation'));
    }
}
