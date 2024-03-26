<?php

namespace App\Http\Controllers\API;

use App\DTOs\JobsListDTO;
use App\Http\Controllers\Controller;
use App\Services\JobsService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

final class JobsController extends Controller
{
    public function index(JobsListDTO $dto, JobsService $service): AnonymousResourceCollection
    {
        return $service->list($dto);
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
