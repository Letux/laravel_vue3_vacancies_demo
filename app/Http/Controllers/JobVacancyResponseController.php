<?php

namespace App\Http\Controllers;

use App\Models\JobVacancyResponse;
use Illuminate\Http\Request;

class JobVacancyResponseController extends Controller
{
    public function index()
    {
        return JobVacancyResponse::all();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'job_vacancy_id' => ['required', 'integer'],
            'user_id' => ['required', 'integer'],
        ]);

        return JobVacancyResponse::create($data);
    }

    public function show(JobVacancyResponse $jobVacancyResponse)
    {
        return $jobVacancyResponse;
    }

    public function update(Request $request, JobVacancyResponse $jobVacancyResponse)
    {
        $data = $request->validate([
            'job_vacancy_id' => ['required', 'integer'],
            'user_id' => ['required', 'integer'],
        ]);

        $jobVacancyResponse->update($data);

        return $jobVacancyResponse;
    }

    public function destroy(JobVacancyResponse $jobVacancyResponse)
    {
        $jobVacancyResponse->delete();

        return response()->json();
    }
}
