<?php

namespace App\Services;

use App\DTOs\JobsListDTO;
use App\Http\Resources\JobVacancyResource;
use App\Repositories\JobsRepository;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

final readonly class JobsService
{
    public function __construct(private JobsRepository $repository)
    {
    }

    public function list(JobsListDTO $data): AnonymousResourceCollection
    {
        if ($data->sort_by === 'published') {
            $data->sort_by = 'created_at';
        }

        return JobVacancyResource::collection($this->repository->getList($data->date_from, $data->date_to, $data->sort_by, $data->sort_order));
    }
}
