<?php

namespace Tests\Unit\Repositories;

use App\Enums\SortOrder;
use App\Models\JobVacancy;
use App\Models\User;
use App\Repositories\JobsRepository;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class JobsRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private readonly JobsRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = app(JobsRepository::class);
    }

    #[Test]
    public function get_list_range()
    {
        $user = User::factory()->create();

        $job1 = JobVacancy::factory()->create(['user_id' => $user->id, 'created_at' => Carbon::create('2024-01-01')]);
        $job2 = JobVacancy::factory()->create(['user_id' => $user->id, 'created_at' => Carbon::create('2024-01-02')]);
        $job3 = JobVacancy::factory()->create(['user_id' => $user->id, 'created_at' => Carbon::create('2024-01-03')]);

        $result = $this->repository->getList(Carbon::create('2024-01-03'), null, null, null);

        $this->assertTrue($result instanceof Collection);
        $this->assertCount(1, $result);
        $this->assertSame($job3->id, $result->first()->id);

        $result = $this->repository->getList(Carbon::create('2024-01-02'), null, null, null);
        $this->assertCount(2, $result);
        $this->assertSame($job2->id, $result->last()->id);

        $result = $this->repository->getList(Carbon::create('2024-01-01'), Carbon::create('2024-01-02'), null, null);
        $this->assertCount(2, $result);
        $this->assertSame($job2->id, $result->get(0)->id);
        $this->assertSame($job1->id, $result->get(1)->id);

        $result = $this->repository->getList(Carbon::create('2024-01-02'), Carbon::create('2024-01-03'), null, null);
        $this->assertCount(2, $result);
        $this->assertSame($job3->id, $result->get(0)->id);
        $this->assertSame($job2->id, $result->get(1)->id);
    }

    #[Test]
    public function get_list_sort()
    {
        $user = User::factory()->create();

        $job1 = JobVacancy::factory()->create(['user_id' => $user->id, 'created_at' => Carbon::create('2024-01-01')]);
        $job2 = JobVacancy::factory()->create(['user_id' => $user->id, 'created_at' => Carbon::create('2024-01-02')]);
        $job3 = JobVacancy::factory()->create(['user_id' => $user->id, 'created_at' => Carbon::create('2024-01-03')]);

        $result = $this->repository->getList(null, null, 'created_at', SortOrder::ASC);

        $this->assertTrue($result instanceof Collection);
        $this->assertCount(3, $result);
        $this->assertSame($job1->id, $result->first()->id);
        $this->assertSame($job3->id, $result->last()->id);

        $result = $this->repository->getList(null, null, 'created_at', SortOrder::DESC);
        $this->assertCount(3, $result);
        $this->assertSame($job3->id, $result->first()->id);
        $this->assertSame($job1->id, $result->last()->id);
    }
}
