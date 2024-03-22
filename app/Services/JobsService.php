<?php

namespace App\Services;

use App\Http\Resources\JobVacancyResource;
use App\Repositories\JobsRepository;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

final readonly class JobsService
{
    public function __construct(private JobsRepository $repository)
    {
    }

    public function list(): AnonymousResourceCollection
    {
        return JobVacancyResource::collection($this->repository->getList());
    }
}
