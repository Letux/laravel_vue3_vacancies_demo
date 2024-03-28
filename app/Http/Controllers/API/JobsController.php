<?php

namespace App\Http\Controllers\API;

use App\DTOs\JobsListDTO;
use App\Http\Controllers\Controller;
use App\Models\JobVacancy;
use App\Services\JobsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

final class JobsController extends Controller
{
    public function index(JobsListDTO $dto, JobsService $service): AnonymousResourceCollection
    {
        return $service->list($dto);
    }

    public function apply(JobVacancy $job, JobsService $service): JsonResponse
    {
        return $service->apply($job, auth()->id());
    }

//    public function create()
//    {
//    }
//
//    public function store(Request $request)
//    {
//    }
//
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
