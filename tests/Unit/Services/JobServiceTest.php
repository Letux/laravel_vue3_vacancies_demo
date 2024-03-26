<?php

namespace Tests\Unit\Services;

use App\DTOs\JobsListDTO;
use App\Http\Resources\JobVacancyResource;
use App\Models\JobVacancy;
use App\Models\User;
use App\Services\JobsService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Carbon;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class JobServiceTest extends TestCase
{
    use RefreshDatabase;

    protected JobsService $service;

    #[\Override]
    protected function setUp() : void
    {
        parent::setUp();
        $this->service = app(JobsService::class);
    }

    #[Test]
    public function list()
    {
        $user = User::factory()->create();

        $job1 = JobVacancy::factory()->create(['user_id' => $user->id, 'created_at' => Carbon::create('2024-01-01')]);
        $job2 = JobVacancy::factory()->create(['user_id' => $user->id, 'created_at' => Carbon::create('2024-01-02')]);
        $job3 = JobVacancy::factory()->create(['user_id' => $user->id, 'created_at' => Carbon::create('2024-01-03')]);

        $dto = JobsListDTO::from([
            'date_from' =>'2024-01-02',
            'date_to' => null,
            'sort_by' => null,
            'sort_order' => null
        ]);

        $result = $this->service->list($dto);
        $this->assertTrue($result instanceof AnonymousResourceCollection);
        $this->assertTrue($result->first() instanceof JobVacancyResource);
        $this->assertCount(2, $result);
        $this->assertSame($job3->id, $result->first()->id);
        $this->assertSame($job2->id, $result->last()->id);

        $dto = JobsListDTO::from([
            'date_from' => null,
            'date_to' => '2024-01-02',
            'sort_by' => null,
            'sort_order' => null
        ]);

        $result = $this->service->list($dto);

        $this->assertCount(2, $result);
        $this->assertSame($job2->id, $result->first()->id);
        $this->assertSame($job1->id, $result->last()->id);

        $dto = JobsListDTO::from([
            'date_from' => '2024-01-01',
            'date_to' => '2024-01-02',
            'sort_by' => 'created_at',
            'sort_order' => 'asc'
        ]);

        $result = $this->service->list($dto);

        $this->assertCount(2, $result);
        $this->assertSame($job1->id, $result->first()->id);
        $this->assertSame($job2->id, $result->last()->id);
    }
}
