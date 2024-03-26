<?php

namespace App\Http\Controllers;

use App\DTOs\CreateJobDTO;
use App\Services\JobsService;
use App\Services\UserService;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

final class JobsController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Jobs/Index', ['fetchJobsUrl' => route('api.jobs.list')]);
    }

    public function create(UserService $service)
    {
        if (!$service->hasCoinsForJobCreation(auth()->user()->coins)) {
            session()->flash('message', 'You do not have enough coins to create a job!');
            return redirect()->route('jobs');
        }

        if ($service->reachedLimitForJobCreation(auth()->id())) {
            session()->flash('message', 'You have reached the limit of jobs you can create today!');
            return redirect()->route('jobs');
        }

        return Inertia::render('Jobs/Create');
    }

    public function store(CreateJobDTO $dto, UserService $userService, JobsService $jobsService): RedirectResponse
    {
        if (!$userService->hasCoinsForJobCreation(auth()->user()->coins)) {
            session()->flash('message', 'You do not have enough coins to create a job!');
            return redirect()->route('jobs');
        }

        if ($userService->reachedLimitForJobCreation(auth()->id())) {
            session()->flash('message', 'You have reached the limit of jobs you can create today!');
            return redirect()->route('jobs');
        }

        return $jobsService->create($dto, auth()->id());
    }

//    public function show($id)
//    {
//    }
//
//    public function edit($id)
//    {
//    }
//
//    public function update(Request $request, $id)
//    {
//    }
//
//    public function destroy($id)
//    {
//    }
}
