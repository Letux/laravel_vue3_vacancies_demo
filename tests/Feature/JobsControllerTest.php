<?php

namespace Tests\Feature;

use App\Models\JobVacancy;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use PHPUnit\Framework\Attributes\Test;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

final class JobsControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function index_works()
    {
        $response = $this->get(route('jobs'));
        $response->assertStatus(Response::HTTP_OK);
    }

    #[Test]
    public function create_not_auth_denied()
    {
        $response = $this->get(route('jobs.create'));
        $response->assertStatus(Response::HTTP_FOUND);
    }

    #[Test]
    public function create_auth_works()
    {
        config(['jobs.coins_for_job_creation' => 2]);

        $user = User::factory()->create(['coins' => 2]);

        $this->actingAs($user);
        $response = $this->get(route('jobs.create'));

        $response->assertStatus(Response::HTTP_OK);
    }

    #[Test]
    public function create_not_enough_coins_redirect()
    {
        config(['jobs.coins_for_job_creation' => 2]);
        $user = User::factory()->create(['coins' => 1]);

        $this->actingAs($user);
        $response = $this->get(route('jobs.create'));

        $response->assertStatus(Response::HTTP_FOUND);
    }

    #[Test]
    public function create_reached_limit_redirect()
    {
        config(['jobs.coins_for_job_creation' => 2]);
        $user = User::factory()->create(['coins' => 1]);

        config(['jobs.max_jobs_per_day' => 2]);
        JobVacancy::factory()->count(2)->create(['user_id' => $user->id]);

        $this->actingAs($user);
        $response = $this->get(route('jobs.create'));

        $response->assertStatus(Response::HTTP_FOUND);
    }

    #[Test]
    public function store_not_auth_denied()
    {
        $response = $this->post(route('jobs.store'));
        $response->assertStatus(Response::HTTP_FOUND);
    }

    #[Test]
    public function store_not_enough_coins_redirect()
    {
        config(['jobs.coins_for_job_creation' => 2]);
        $user = User::factory()->create(['coins' => 1]);

        $this->assertCount(0, JobVacancy::all());

        $this->actingAs($user);
        $response = $this->post(route('jobs.store'), [
            'title' => 'Test',
            'description' => 'Test',
        ]);

        $this->assertCount(0, JobVacancy::all());

        $response->assertStatus(Response::HTTP_FOUND);
    }

    #[Test]
    public function store_reached_limit_redirect()
    {
        config(['jobs.coins_for_job_creation' => 2]);
        $user = User::factory()->create(['coins' => 2]);

        config(['jobs.max_jobs_per_day' => 2]);
        JobVacancy::factory()->count(2)->create(['user_id' => $user->id]);

        $this->assertCount(2, JobVacancy::all());

        $this->actingAs($user);
        $response = $this->post(route('jobs.store'), [
            'title' => 'Test',
            'description' => 'Test',
        ]);

        $this->assertCount(2, JobVacancy::all());

        $response->assertStatus(Response::HTTP_FOUND);
    }

    #[Test]
    public function store_works()
    {
        config(['jobs.coins_for_job_creation' => 2]);
        $user = User::factory()->create(['coins' => 2]);

        $this->assertCount(0, JobVacancy::all());

        $this->actingAs($user);
        $response = $this->post(route('jobs.store'), [
            'title' => 'Test',
            'description' => 'Test',
        ]);

        $this->assertCount(1, JobVacancy::all());

        $response->assertStatus(Response::HTTP_FOUND);
    }
}
