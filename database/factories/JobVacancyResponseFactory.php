<?php

namespace Database\Factories;

use App\Models\JobVacancyResponse;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

final class JobVacancyResponseFactory extends Factory
{
    protected $model = JobVacancyResponse::class;

    public function definition(): array
    {
        return [
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'job_vacancy_id' => $this->faker->randomNumber(),
            'user_id' => $this->faker->randomNumber(),
        ];
    }
}
