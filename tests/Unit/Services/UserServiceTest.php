<?php

namespace Tests\Unit\Services;

use App\Exceptions\NotEnoughCoinsForJobCreationException;
use App\Models\JobVacancy;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class UserServiceTest extends TestCase
{
    use RefreshDatabase;

    protected UserService $service;

    #[\Override]
    protected function setUp(): void
    {
        parent::setUp();

        $this->service = app(UserService::class);
    }

    #[Test]
    public function hasCoinsForJobCreation()
    {
        config(['jobs.coins_for_job_creation' => 2]);

        $this->assertFalse($this->service->hasCoinsForJobCreation(1));
        $this->assertTrue($this->service->hasCoinsForJobCreation(2));
    }

    #[Test]
    public function reachedLimitForJobCreation()
    {
        config(['jobs.max_jobs_per_day' => 2]);
        $user = User::factory()->create();

        $count = JobVacancy::get()->count();
        $this->assertEquals(0, $count);

        $this->assertFalse($this->service->reachedLimitForJobCreation($user->id));

        JobVacancy::factory()->create(['user_id' => $user->id]);

        $this->assertFalse($this->service->reachedLimitForJobCreation($user->id));

        JobVacancy::factory()->create(['user_id' => $user->id]);

        $this->assertTrue($this->service->reachedLimitForJobCreation($user->id));
    }

    #[Test]
    public function decrementCoinsForJobCreation_throw_exception()
    {
        config(['jobs.coins_for_job_creation' => 2]);

        $user = User::factory()->create(['coins' => 1]);
        JobVacancy::factory()->create(['user_id' => $user->id]);

        $this->expectException(NotEnoughCoinsForJobCreationException::class);

        $this->service->decrementCoinsForJobCreation($user, JobVacancy::first());
    }

    #[Test]
    public function decrementCoinsForJobCreation()
    {
        config(['jobs.coins_for_job_creation' => 2]);

        $user = User::factory()->create(['coins' => 2]);
        JobVacancy::factory()->create(['user_id' => $user->id]);

        $this->service->decrementCoinsForJobCreation($user, JobVacancy::first());

        $this->assertEquals(0, $user->fresh()->coins);
    }
}
