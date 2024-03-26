<?php

namespace Tests\Feature\API;

use App\Models\JobVacancy;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class JobsControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function testBasic()
    {
        $user = User::factory()->create();
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        $job1 = JobVacancy::factory()->create(['user_id' => $user1->id, 'created_at' => Carbon::create('2024-01-01')]);
        $job2 = JobVacancy::factory()->create(['user_id' => $user2->id, 'created_at' => Carbon::create('2024-01-02')]);
        $job3 = JobVacancy::factory()->create(['user_id' => $user->id, 'created_at' => Carbon::create('2024-01-03')]);

        $this->actingAs($user);

        $response = $this->getJson(route('api.jobs.list', [
        'date_from' => '2024-01-02',
            'date_to' => null,
            'sort_by' => null,
            'sort_order' => null
        ]));
        $response->assertStatus(200);

        $response->assertJsonCount(2);
        $response->assertJsonPath('0.id', $job3->id);
        $response->assertJsonPath('1.id', $job2->id);

        $response = $this->getJson(route('api.jobs.list', [
            'date_from' => null,
            'date_to' => '2024-01-02',
            'sort_by' => null,
            'sort_order' => null
        ]));

        $response->assertJsonCount(2);
        $response->assertJsonFragment(['id' => $job2->id]);
        $response->assertJsonFragment(['id' => $job1->id]);

        $response = $this->getJson(route('api.jobs.list', [
            'date_from' => '2024-01-01',
            'date_to' => '2024-01-02',
            'sort_by' => 'published',
            'sort_order' => 'asc'
        ]));

        $response->assertJsonCount(2);
        $response->assertJsonPath('0.id', $job1->id);
        $response->assertJsonPath('1.id', $job2->id);
    }
}
